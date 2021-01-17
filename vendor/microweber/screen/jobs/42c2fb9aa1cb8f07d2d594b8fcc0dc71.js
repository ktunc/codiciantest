var page = require('webpage').create();

page.viewportSize = {width: 1200, height: 800};




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
