const puppeteer = require("puppeteer-extra");

async function run() {

    const browser = await puppeteer.launch({ headless: false, args:[
            '--start-maximized' // you can also use '--start-fullscreen'
        ] });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1920,
        height: 1080,
        deviceScaleFactor: 1,
    });

        await page.goto("https://www.kayak.co.uk/flights/LON-PFO/2023-05-26?sort=bestflight_a&fs=stops=0");
        await page.waitForSelector('.Hv20-content .Hv20-value div span');
        let data = await page.evaluate(() => {
            let results = [];
            let price = document.querySelector('.Hv20-content .Hv20-value div span');
            results.push({
                price:price.innerHTML
            })
            return results;
        });
        const fs = require('fs');
        fs.writeFileSync('scrape/flightPrice.json',JSON.stringify(data));
       browser.close();

}
run();


