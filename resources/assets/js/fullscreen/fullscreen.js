document.addEventListener('DOMContentLoaded', loadFullScreen)

function loadFullScreen() {

    let fullScreen = document.getElementById('gotoFullScreen');

    if (!fullScreen) {
        return;
    }

    fullScreen.addEventListener(
        'click',
        function () {
            if (window.innerHeight == screen.height) {
                document.exitFullscreen();
            }
            document.body.requestFullscreen();
            $('body').attr({'style': 'height: 100%; overflow: auto;'});
        },
        false,
    );
}
