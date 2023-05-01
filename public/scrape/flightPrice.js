const puppeteer = require("puppeteer-extra");
const fs = require("fs");

async function run() {

    const browser = await puppeteer.launch({ headless: false, args:[
            '--start-maximized'
        ] });
    const page = await browser.newPage();
    await page.setViewport({
        width: 1920,
        height: 1080,
        deviceScaleFactor: 1,
    });
    const url = process.argv[2];
    await page.goto(url);
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


