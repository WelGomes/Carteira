const element = document.getElementById('error');

if(element) {
    document.getElementById('error').style.color = '#c41026';
    document.getElementById('passwordLogin').style.borderColor = '#c41026';
    document.getElementById('emailLogin').style.borderColor = '#c41026';
}

setTimeout(() => {
    document.getElementById('error').style.display = 'none';
    document.getElementById('passwordLogin').style.borderColor = 'rgb(40, 60, 80)';
    document.getElementById('emailLogin').style.borderColor = 'rgb(40, 60, 80)';
}, '5000');