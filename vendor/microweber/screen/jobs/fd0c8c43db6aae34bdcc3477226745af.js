var page = require('webpage').create();

page.viewportSize = {width: 1024, height: 768};




page.open('https://myk.gov.tr', function (status) {
    if (status !== 'success') {
        console.log('Unable to load the address!');
        phantom.exit(1);
    }

    
    page.evaluate(function() {
                    /* This will set the page background color */
            if (document && document.body) {
                document.body.bgColor = '#FFFFFF';
            }
        
            });

    setTimeout(function() {
            page.render('E:\\tttt.jpg');
            phantom.exit();
    }, 0);
});
