// Phần code thông báo notification -->
const notification = document.getElementById('notification');
const notificationText = document.getElementById('notification-text');
const closeNotification = document.getElementById('close-notification');
// Hàm hiển thị thông báo
function showNotification(message) {
    notificationText.innerText = message;
    notification.style.display = 'block';
    setTimeout(() => {
        hideNotification();
    }, 2000);
}
// Hàm ẩn thông báo
function hideNotification() {
    notification.style.display = 'none';
}

// Sự kiện click để đóng thông báo
closeNotification.addEventListener('click', hideNotification);




// ------------------------------------------------------------------------------------------------------------------
