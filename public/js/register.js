
const elemento = document.getElementById('error');

if (elemento) {
    document.getElementById('error').style.color = '#c41026';
    document.getElementById('name').style.borderColor = '#c41026';
    document.getElementById('lastName').style.borderColor = '#c41026';
    document.getElementById('email').style.borderColor = '#c41026';
    document.getElementById('password').style.borderColor = '#c41026';
 
}
setTimeout(() => {
    document.getElementById('error').style.borderColor = 'rgb(40, 60, 80)';
    document.getElementById('name').style.borderColor = 'rgb(40, 60, 80)';
    document.getElementById('lastName').style.borderColor = 'rgb(40, 60, 80)';
    document.getElementById('email').style.borderColor = 'rgb(40, 60, 80)';
    document.getElementById('password').style.borderColor = 'rgb(40, 60, 80)';
    elemento.style.display = 'none';
}, "5000");