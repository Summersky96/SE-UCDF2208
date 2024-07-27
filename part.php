<?php 
include('mecnavbar.php');
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart = json_decode(file_get_contents('php://input'), true);

    foreach ($cart as $item) {
        $name = $item['name'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $total_price = $price * $quantity;
        $status = 'Shipping';

        $stmt = $con->prepare("INSERT INTO orders (name, price, quantity, total_price, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdids", $name, $price, $quantity, $total_price, $status);
        $stmt->execute();
    }

    echo "Order placed successfully";
    $stmt->close();
}
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parts Store</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        
        section {
            top: 13%;
            color: #333;
            transition: all 0.2s ease;
        }
        .cart-icon {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 2rem;
            cursor: pointer;
            color: #333;
        }
        .cart-count {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: red;
            color: white;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 50%;
        }
        body.dark-mode .cart-icon {
            color: #fff;
        }
        .cart-modal {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.2s ease;
        }
        .cart-modal .cart-header {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            font-weight: 600;
        }
        .cart-modal .cart-body {
            padding: 10px;
        }
        .cart-modal .cart-footer {
            padding: 10px;
            border-top: 1px solid #ccc;
            text-align: right;
        }
        .cart-modal .cart-footer button {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .parts {
            text-align: center;
            padding: 20px;
        }
        .heading {
            margin-bottom: 40px;
        }
        .heading span {
            display: inline-block;
            font-size: 40px;
            font-weight: 500;
            color: #ffe000;
            margin-bottom: 8px;
        }
        .heading p {
            font-size: 18px;
            font-weight: 400;
        }
        body.dark-mode .heading p{
            color: #fff;
        }
        .partscontainer {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            justify-content: center;
            margin-top: 32px;
        }
        .partscontainer .box {
            flex: 1 1 17rem;
            position: relative;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #f9f9f9;
            border-radius: 8px;
            transition: transform 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        body.dark-mode .partscontainer .box,
        .dark-mode .preview{
            background: #a6a2a2;
        }
        .partscontainer .box:hover {
            transform: scale(1.05);
        }
        .partscontainer .box img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 16px;
            border-radius: 8px;
        }
        .partscontainer .box h3 {
            font-size: 17.5px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        body.dark-mode .partscontainer .box h3 {
            color: #e5e6e4;
        }
        .partscontainer .box span {
            font-size: 17.5px;
            font-weight: 600;
            color: #ffe000;
            margin-bottom: 16px;
        }
        .partscontainer .box button,
        .products-preview .preview button {
            max-width: 120px;
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-bottom: 16px;
            transition: background-color 0.3s ease;
        }
        .partscontainer .box button:hover,
        .products-preview .preview button:hover {
            background-color: #ffe000;
            color: #333;
        }
        
        .partscontainer .box .details {
            font-size: 16px;
            color: black;
            transition: color 0.3s ease;
        }
        .partscontainer .box .details:hover {
            color: #ffe000;
            text-decoration: underline;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .cart-item div {
            display: flex;
            align-items: center;
        }
        .cart-item .item-name {
            margin-right: 10px;
        }
        .cart-item button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        .cart-item button:hover {
            background-color: red;
        }
        .cart-item .remove-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .products-preview {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .preview {
            display: none;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .preview.active {
            display: block;
        }

        .preview img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .preview .price {
            display: block;
            margin: 10px 0;
            font-size: 20px;
            font-weight: bold;
            color: #ffe000;
        }

        .preview .fas.fa-times {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 20px;
            padding: 5px 5px;
            border-radius: 2px;
            transition: all .1s ease;
            color: #333;
        }
        body.dark-mode .preview .fas.fa-times{
            color: #fff;
        }

        .preview .fas.fa-times:hover{
            background-color: red;
        }

        a{
            cursor: pointer;
        }
        .preview p{
            color: #333;
        }
        body.dark-mode .cart-modal{
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <section>
        <div class="cart-icon">
            <i class='bx bx-cart'></i>
            <span class="cart-count" id="cartCount">0</span>
        </div>
        <div class="cart-modal" id="cartModal">
            <div class="cart-header">Cart</div>
            <div class="cart-body" id="cartItems"></div>
            <div class="cart-footer">
                <strong>Total: RM <span id="cartTotal">0</span></strong>
                <button onclick="checkout()">Checkout</button>
            </div>
        </div>
        <div class="parts" id="parts">
            <div class="heading">
                <span>Order Parts</span>
                <p>Choose the parts to order from manufacturer.</p>
            </div>
            <div class="partscontainer">
                <article class="box" data-name="Tyre Rim" data-price="400">
                    <img src="rim.png" alt="Tyre Rim">
                    <h3>Tyre Rim</h3>
                    <span>RM 400</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Tyre Rim">View Details</a>
                </article>
                <article class="box" data-name="Head Lights" data-price="1000">
                    <img src="headlight.png" alt="Head Lights">
                    <h3>Head Lights</h3>
                    <span>RM 1000</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Head Lights">View Details</a>
                </article>
                <article class="box" data-name="Suspension" data-price="500">
                    <img src="suspension.png" alt="Suspension">
                    <h3>Suspension</h3>
                    <span>RM 500</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Suspension">View Details</a>
                </article>
                <article class="box" data-name="Engine Air Filters" data-price="200">
                    <img src="airfilter.png" alt="Engine Air Filters">
                    <h3>Engine Air Filters</h3>
                    <span>RM 200</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Engine Air Filters">View Details</a>
                </article>
                <article class="box" data-name="Break Pads" data-price="1500">
                    <img src="breakpads.png" alt="Break Pads">
                    <h3>Break Pads</h3>
                    <span>RM 1500</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Break Pads">View Details</a>
                </article>
                <article class="box" data-name="Windshield Wiper" data-price="60">
                    <img src="wiper.png" alt="Windshield Wiper">
                    <h3>Windshield Wiper</h3>
                    <span>RM 60</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Windshield Wiper">View Details</a>
                </article>
                <article class="box" data-name="Mirrors" data-price="240">
                    <img src="mirrors.png" alt="Mirrors">
                    <h3>Mirrors</h3>
                    <span>RM 240</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Mirrors">View Details</a>
                </article>
                <article class="box" data-name="Batteries" data-price="1200">
                    <img src="batteries.png" alt="Batteries">
                    <h3>Batteries</h3>
                    <span>RM 1200</span>
                    <button type="button" onclick="addToCart(this)">Order Now</button>
                    <a class="details" data-name="Batteries">View Details</a>
                </article>
            </div>
        </div>
    </section>
    <div class="products-preview">
        <div class="preview" data-price="350" data-target="Tyre Rim">
            <i class="fas fa-times"></i>
            <img src="rim.png" alt="Tyre Rim">
            <h3>Tyre Rim</h3>
            <p>The outer edge of a wheel that holds the tyre in place, providing a seat for the tyre bead and enabling attachment to the vehicle.</p>
            <span class="price">RM 350</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="1000" data-target="Head Lights">
            <i class="fas fa-times"></i>
            <img src="headlight.png" alt="Head Lights">
            <h3>Head Lights</h3>
            <p>Front-facing lamps on a vehicle designed to illuminate the road ahead and ensure visibility during low-light conditions.</p>
            <span class="price">RM 1000</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="500" data-target="Suspension">
            <i class="fas fa-times"></i>
            <img src="suspension.png" alt="Suspension">
            <h3>Suspension</h3>
            <p>The system of springs, shock absorbers, and linkages connecting a vehicle to its wheels, providing stability, handling, and comfort by absorbing and dampening road shocks.</p>
            <span class="price">RM 500</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="200" data-target="Engine Air Filters">
            <i class="fas fa-times"></i>
            <img src="airfilter.png" alt="Engine Air Filters">
            <h3>Engine Air Filters</h3>
            <p>Engine air filters are essential components that prevent dirt, dust, and debris from entering your vehicle's engine, ensuring clean airflow and optimal performance.</p>
            <span class="price">RM 200</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="1500" data-target="Break Pads">
            <i class="fas fa-times"></i>
            <img src="breakpads.png" alt="Break Pads">
            <h3>Break Pads</h3>
            <p>Components in a braking system that press against the brake disc to create friction, slowing down or stopping the vehicle.</p>
            <span class="price">RM 1500</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="60" data-target="Windshield Wiper">
            <i class="fas fa-times"></i>
            <img src="wiper.png" alt="Windshield Wiper">
            <h3>Windshield Wiper</h3>
            <p>Important for clear visibility during rain and snow. Each order contains two windshield wipers.</p>
            <span class="price">RM 60</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="240" data-target="Mirrors">
            <i class="fas fa-times"></i>
            <img src="mirrors.png" alt="Mirrors">
            <h3>Mirrors</h3>
            <p>Important for clear visibility during rain and snow. Each order contains two mirrors.</p>
            <span class="price">RM 240</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
        <div class="preview" data-price="1200" data-target="Batteries">
            <i class="fas fa-times"></i>
            <img src="batteries.png" alt="Batteries">
            <h3>Batteries</h3>
            <p>Provide power to start the engine and run electrical systems.</p>
            <span class="price">RM 1200</span>
            <button type="button" onclick="addToCart(this)">Order Now</button>
        </div>
    </div>

    <?php include('footer.php') ?>
    <script>
    const cart = [];
    const cartModal = document.getElementById('cartModal');
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const cartIcon = document.querySelector('.cart-icon');
    const cartCount = document.getElementById('cartCount');
    const productBoxes = document.querySelectorAll('.partscontainer .details');
    const previewContainer = document.querySelector('.products-preview');
    const previewBoxes = document.querySelectorAll('.preview');

    productBoxes.forEach(details => {
        details.addEventListener('click', () => {
            const name = details.getAttribute('data-name');
            previewContainer.style.display = 'flex';
            previewBoxes.forEach(preview => {
                const target = preview.getAttribute('data-target');
                if (name === target) {
                    preview.classList.add('active');
                }
            });
        });
    });

    previewBoxes.forEach(preview => {
        const closeIcon = preview.querySelector('.fas.fa-times');
        // const backBtn = preview.querySelector('.back-btn');
        const closePreview = () => {
            preview.classList.remove('active');
            previewContainer.style.display = 'none';
        };

        closeIcon.addEventListener('click', closePreview);
        // backBtn.addEventListener('click', closePreview);
    });
    

    cartIcon.addEventListener('click', () => {
        cartModal.style.display = cartModal.style.display === 'block' ? 'none' : 'block';
    });

    function addToCart(button) {
    const box = button.closest('.box');  // For regular product boxes
    const preview = button.closest('.preview');  // For preview boxes

    // Determine if it's a regular product box or a preview box
    if (box) {
        const name = box.getAttribute('data-name');
        const price = parseInt(box.getAttribute('data-price'));
        addItemToCart(name, price);
    } else if (preview) {
        const name = preview.getAttribute('data-target');
        const price = parseInt(preview.getAttribute('data-price'));
        addItemToCart(name, price);
    }

    alert("Item added to cart.");
    updateCart();
}

function addItemToCart(name, price) {
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, quantity: 1, status: 'pending' });
    }
}


    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        let itemCount = 0;
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemCount += item.quantity;

            const div = document.createElement('div');
            div.classList.add('cart-item');
            div.innerHTML = `
                <div>
                    <span class="item-name">${item.name}</span>
                    <button onclick="decreaseQuantity('${item.name}')">-</button>
                    <span class="item-quantity">${item.quantity}</span>
                    <button onclick="increaseQuantity('${item.name}')">+</button>
                </div>
                <div>
                    <span class="item-price">RM ${itemTotal}</span>
                    <button class="remove-btn" onclick="removeItem('${item.name}')">Remove</button>
                </div>
            `;

            cartItemsContainer.appendChild(div);
        });

        cartTotal.textContent = total;
        cartCount.textContent = itemCount;
        cartCount.style.display = itemCount ? 'inline' : 'none';
    }

    function increaseQuantity(name) {
        const item = cart.find(item => item.name === name);
        if (item) {
            item.quantity += 1;
            updateCart();
        }
    }

    function decreaseQuantity(name) {
        const item = cart.find(item => item.name === name);
        if (item && item.quantity > 1) {
            item.quantity -= 1;
            updateCart();
        } else {
            removeItem(name);
        }
    }

    function removeItem(name) {
        const itemIndex = cart.findIndex(item => item.name === name);
        if (itemIndex !== -1) {
            cart.splice(itemIndex, 1);
            updateCart();
        }
    }

    function checkout() {
        if (confirm("Are you sure you want to checkout these items?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "part.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Order placed successfully.');
                    window.location.href="parthistory.php";
                    cart.length = 0;  // Clear the cart
                    updateCart();     // Refresh the cart display
                    cartModal.style.display = 'none';  // Close the cart modal
                }
            };

            const data = JSON.stringify(cart);
            xhr.send(data);
        }
    }

    updateCart(); // Initial update to set the cart count

    
</script>

</body>
</html>
