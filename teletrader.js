const puppeteer = require('puppeteer');

async function run() {
    const browser = await puppeteer.launch({ headless: true, args:[
            '--start-maximized' // you can also use '--start-fullscreen'
        ]});
    const page = await browser.newPage();
    await page.setViewport({
        width: 1920,
        height: 1080,
        deviceScaleFactor: 1,
    });
    await page.goto("https://www.teletrader.com/user/login");
    await page.waitForTimeout(5000);
    let selector = 'a';
    await page.$$eval(selector, anchors => {
        anchors.map(anchor => {
            if (anchor.textContent == 'LOGIN') {
                anchor.click();
                return
            }
        })
    });
    await page.waitForTimeout(5000);
    await page.type('#Username', 'nurse_stephen@hotmail.com');
    await page.type('#Password', 'Descartes99!');
    await page.click("#LoginTermsAccepted", {clickCount:1});
    await page.click('#LoginButton');
    //await page.waitForTimeout(5000);
    // navigationPromise = page.waitForNavigation();
    // await navigationPromise;
    // let economicLink = 'a';
    // await page.$$eval(economicLink, anchors => {
    //     anchors.map(anchor => {
    //         if (anchor.textContent == 'Economic Data') {
    //             anchor.click();
    //             return
    //         }
    //     })
    // });
    const page2 = await browser.newPage();
    // open new tab
    await page2.setViewport({
        width: 1920,
        height: 1080,
        deviceScaleFactor: 1,
    });
    await page2.goto('https://www.teletrader.com/economic-calendar');       // go to github.com
    await page2.bringToFront();
    await page.waitForTimeout(5000);
    await page2.waitForSelector('#Yesterday');
    // await page.click('#Yesterday');
    await page2.click('#Yesterday');
    await page2.waitForTimeout(5000);
    const [span] = await page2.$x("//span[contains(., 'Medium Volatility')]");
    if (span) {
        await span.click();
    }
    const [span2] = await page2.$x("//span[contains(., 'High Volatility')]");
    if (span2) {
        await span2.click();
    }

    await page2.waitForTimeout(5000);
    // await page2.screenshot({ path: 'screenshot.png' });
    let data = [];
    let yesterday = await page2.evaluate(() => {



        var elements = document.querySelectorAll('#Ajax_SearchResults table tbody .tablehead');
        for (var i = 0; i < elements.length; i++) {
            elements[i].parentNode.removeChild(elements[i]);
        }
        let results = [];
        let items = document.querySelectorAll('#Ajax_SearchResults table tbody tr');


        items.forEach((item) => {


            results.push({
                time: item.querySelector('td .dateTime').getAttribute('title'),
                country: item.querySelector('td .flags').innerHTML,
                name: item.querySelector('td:nth-child(5)').innerHTML,
                impact: item.querySelector('td i').getAttribute('class'),
                actual: item.querySelector('td:nth-child(6)').innerHTML,
                consensus: item.querySelector('td:nth-child(7)').innerHTML,
                previous: item.querySelector('td:nth-child(8)').innerHTML



            });
        })

        // page.waitForSelector('#Tomorrow');
        // // await page.click('#Yesterday');
        // page.click('#Tomorrow');
        // page.waitForTimeout(5000);
        // page.screenshot({ path: 'screenshot2.png' });



        return results;


    });
    data = data.concat(yesterday);
    // today

    await page2.waitForSelector('#Today');
    await page2.click('#Today');
    await page2.waitForTimeout(5000);
    let today = await page2.evaluate(() => {



        var elements = document.querySelectorAll('#Ajax_SearchResults table tbody .tablehead');
        for (var i = 0; i < elements.length; i++) {
            elements[i].parentNode.removeChild(elements[i]);
        }
        let results = [];
        let items = document.querySelectorAll('#Ajax_SearchResults table tbody tr');


        items.forEach((item) => {


            results.push({
                time: item.querySelector('td .dateTime').getAttribute('title'),
                country: item.querySelector('td .flags').innerHTML,
                name: item.querySelector('td:nth-child(5)').innerHTML,
                impact: item.querySelector('td i').getAttribute('class'),
                actual: item.querySelector('td:nth-child(6)').innerHTML,
                consensus: item.querySelector('td:nth-child(7)').innerHTML,
                previous: item.querySelector('td:nth-child(8)').innerHTML



            });
        });



        return results;

    });
    data = data.concat(today);
    //today end

    //tomorrow

    await page2.waitForSelector('#Tomorrow');
    await page2.click('#Tomorrow');
    await page2.waitForTimeout(5000);
    let tomorrow = await page2.evaluate(() => {



        var elements = document.querySelectorAll('#Ajax_SearchResults table tbody .tablehead');
        for (var i = 0; i < elements.length; i++) {
            elements[i].parentNode.removeChild(elements[i]);
        }
        let results = [];
        let items = document.querySelectorAll('#Ajax_SearchResults table tbody tr');


        items.forEach((item) => {


            results.push({
                time: item.querySelector('td .dateTime').getAttribute('title'),
                country: item.querySelector('td .flags').innerHTML,
                name: item.querySelector('td:nth-child(5)').innerHTML,
                impact: item.querySelector('td i').getAttribute('class'),
                actual: item.querySelector('td:nth-child(6)').innerHTML,
                consensus: item.querySelector('td:nth-child(7)').innerHTML,
                previous: item.querySelector('td:nth-child(8)').innerHTML



            });
        });



        return results;

    });
    data = data.concat(tomorrow);
    //tomorrow end



    const fs = require('fs');
    fs.writeFileSync('economicData.json', JSON.stringify(data));
     browser.close();


    return data;
}
run();











