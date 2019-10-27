window.onload = function() {
    
    var buttons = document.getElementsByClassName('jcss-button');
    for (var i = 0; i< buttons.length; i++) {
        buttons[i].addEventListener('click', function(e) {   
            e.preventDefault();
    
            var top = (screen.availHeight - 500) / 2;
            var left = (screen.availWidth - 500) / 2;
            window.open(this.href, 
                        'JC Social Sharing', 
                        'height=530, width=580, top=' + top + ', left=' + left + ', toolbar=0, location=0, menubar=0, status=0, scrollbars=1, resizable=1');
            return false;    
        });
    }  
}