let darkMode = false;
const userTheme = localStorage.getItem('theme');

$(function () {
    
    const $btn = $('#themeBtn');
    const $html = $('#htmlPage');
    
    if ($btn.length) {

        if (userTheme === 'dark') {
            $btn.text('Off');
            $btn.addClass('on');//추가1
            darkMode = true;
        } else if (userTheme === 'light') {
            $btn.text('On');
            $btn.removeClass('on')//추가2
            darkMode = false;
        }
        
        $btn.on('click', function () {
            if (!darkMode) {
                clickDarkMode();
            } else {
                clickLightMode();
            }
        });

        function clickDarkMode() {
            $btn.text('Off');
            $btn.addClass('on'); //추가3
            localStorage.setItem("theme", "dark");
            $html.attr("data-bs-theme", "dark");
            darkMode = true;
        }

        function clickLightMode() {
            $btn.text('On');
            $btn.removeClass('on'); //추가4
            localStorage.setItem("theme", "light");
            $html.attr("data-bs-theme", "light");
            darkMode = false;
        }
    }
});