const puppeteer = require("puppeteer-extra");
const fs = require("fs");
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())

// puppeteer usage as normal
puppeteer.launch({ headless: true, args:[
        '--start-maximized'
    ],slowMO:500 }).then(async browser => {
// async function run() {

    const page = await browser.newPage();
    await page.setViewport({
        width: 1280,
        height: 720,
        deviceScaleFactor: 1,
    });
     const url = process.argv[2];
    await page.goto(url, { waitUntil: 'domcontentloaded' });

    await page.waitForSelector('.vrY3');
    await page.click('.vrY3 .iInN .iInN-footer button');
    await page.waitForSelector('.Hv20-content .Hv20-value div span');
    await new Promise(r => setTimeout(r, 5000));

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
})


