// const puppeteer = require("puppeteer-extra");
// const fs = require("fs");
//
// async function run() {
//
//     const browser = await puppeteer.launch({ headless:false, args:[
//             '--start-maximized'
//         ] });
//     const page = await browser.newPage();
//     await page.setViewport({
//         width: 1920,
//         height: 1080,
//         deviceScaleFactor: 1,
//     });
//     const url = process.argv[2];
//    // const url = 'https://www.kayak.co.uk/flights/PFO-LON/2023-05-25?sort=bestflight_a&fs=stops=0';
//     await page.goto(url, { waitUntil: 'networkidle0' });
//
//     await page.waitForSelector('.Hv20-content .Hv20-value div span');
//     let data = await page.evaluate(() => {
//         let results = [];
//         let price = document.querySelector('.Hv20-content .Hv20-value div span');
//         results.push({
//             price:price.innerHTML
//         })
//         return results;
//     });
//     const fs = require('fs');
//     fs.writeFileSync('scrape/flightPrice.json',JSON.stringify(data));
//        browser.close();
//        console.log(data);
//
// }
// run();


///

const puppeteer = require("puppeteer-extra");
const fs = require("fs");
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())

// puppeteer usage as normal
puppeteer.launch({ headless: 'new', args:[
        '--start-maximized'
    ] }).then(async browser => {
// async function run() {

    // const browser = await puppeteer.launch({ headless: 'new', args:[
    //         '--start-maximized'
    //     ] });
    const page = await browser.newPage();

    // await page.setExtraHTTPHeaders({
    //     'user-agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
    //     'upgrade-insecure-requests': '1',
    //     'accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
    //     'accept-encoding': 'gzip, deflate, br',
    //     'accept-language': 'en-US,en;q=0.9,en;q=0.8'
    // });
    //  await page.setRequestInterception(true);
    // page.on('request', async (request) => {
    //     if (request.resourceType() == 'image') {
    //         await request.abort();
    //     } else {
    //         await request.continue();
    //     }
    // });
    await page.setViewport({
        width: 1280,
        height: 720,
        deviceScaleFactor: 1,
    });
    // const url = process.argv[2];
   const url = 'https://www.kayak.co.uk/flights/PFO-LON/2023-05-25?sort=bestflight_a&fs=stops=0';
    await page.goto(url, { waitUntil: 'domcontentloaded' });

    await page.waitForSelector('.vrY3');
    await page.click('.vrY3 .iInN .iInN-footer button');
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
    //fs.writeFileSync('scrape/flightPrice.json',JSON.stringify(data));

    fs.writeFileSync('/var/www/html/stephennurse/public/scrape/flightPrice.json',JSON.stringify(data));
    console.log(data);

    browser.close();
})
// run();


