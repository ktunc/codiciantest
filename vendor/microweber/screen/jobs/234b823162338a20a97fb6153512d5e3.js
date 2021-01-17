var page = require('webpage').create();

page.viewportSize = {width: 1024, height: 768};




page.open('https://myk.gov.tr', function (status) {
    if (status !== 'success') {
        console.log('Unable to load the address!');
        phantom.exit(1);
    }

    
    page.evaluate(function() {
        
            });

    setTimeout(function() {
            page.render('E:\\tttt.png');
            phantom.exit();
    }, 0);
});
