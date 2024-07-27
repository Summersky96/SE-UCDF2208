const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");
const usersList = document.querySelector(".users-list");

function updateUnreadCounts() {
  const statusDots = document.querySelectorAll('.status-dot');
  statusDots.forEach(dot => {
    const unreadCountElement = dot.querySelector('.unread-count');
    if (unreadCountElement) {
      const unreadCount = parseInt(unreadCountElement.textContent, 10);
      if (unreadCount > 0) {
        dot.innerHTML = `<span class="unread-count">${unreadCount}</span>`;
      } else {
        dot.innerHTML = '<i class="fas fa-circle"></i>';
      }
    }
  });
}

// Toggle search bar visibility and focus
searchIcon.onclick = () => {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

// Handle search functionality
searchBar.onkeyup = () => {
  let searchTerm = searchBar.value.trim(); // Trim whitespace from search term
  if (searchTerm !== "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  // Perform AJAX request to fetch search results
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "search copy.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

// Update user list periodically
setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "users copy.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
          updateUnreadCounts(); // Update unread message counts
        }
      }
    }
  }
  xhr.send();
}, 500);
