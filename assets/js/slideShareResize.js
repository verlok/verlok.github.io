// Resize of slideShare presentations. Important about iframe tag: - id MUST be ssFrame - width attribute MUST be 100% - height attribute MUST NOT be set
(function() {
    var pf = document.getElementById('ssFrame'),
        ssBarHeight = 44,
        slidesRatio = 0.75;
    
    function setSize() {
        pf.height = (pf.clientWidth * slidesRatio + ssBarHeight).toString();
    }
    if (!!pf) {
        window.addEventListener('resize', setSize);
        setSize();
    }
}());