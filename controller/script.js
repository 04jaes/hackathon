// Get elements
const signInButton = document.getElementById('SignIn');
const loginPopup = document.getElementById('loginPopup');
const closePopup = document.getElementById('closePopup');

// Show the popup
signInButton.addEventListener('click', () => {
    loginPopup.style.display = 'block';
});

// Close the popup
closePopup.addEventListener('click', () => {
    loginPopup.style.display = 'none';
});

// Close popup if clicked outside content
window.addEventListener('click', (event) => {
    if (event.target === loginPopup) {
        loginPopup.style.display = 'none';
    }
});
