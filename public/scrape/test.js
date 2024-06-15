const puppeteer = require('puppeteer');
const ProxyChain = require('proxy-chain');

async function scrapeData() {
    // free proxy server URL
    const proxyURL = 'http://stephennurse-zone-custom-region-GB-city-london:Descartes99@fus.360s5.com:3600';
    const newProxy = await ProxyChain.anonymizeProxy(proxyURL);


    // launch a browser instance with the
    // --proxy-server Flag enabled

    const browser = await puppeteer.launch({
        headless:false,
        args: [`--proxy-server=${newProxy}`]
    })
    // open a new page in the current browser context
    const page = await browser.newPage();
    page.setDefaultNavigationTimeout(0);

    // visit the target page
    //await page.goto('https://www.google.com')
   // await page.goto('https://stephen-nurse.com/');
     await page.goto('https://clubspark.lta.org.uk/BethnalGreenGardens/Booking/BookByDate#?date=2024-01-05&role=guest');

    // extract the IP the request comes from
    // and print it
    // const body = await page.waitForSelector('body')
    // const ip = await body.getProperty('textContent')
    // console.log(await ip.jsonValue())

    // await browser.close()
}

scrapeData()