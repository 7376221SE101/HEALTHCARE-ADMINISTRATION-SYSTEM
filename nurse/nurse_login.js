function setRole(role) {
    // Update role text
    document.getElementById('roleText').innerText = role;
    
    // Update button states
    document.querySelectorAll('.role-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById(role.toLowerCase() + 'Btn').classList.add('active');
}

