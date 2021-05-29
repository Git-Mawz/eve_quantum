class KillboardClipboard {


    _zkillButton;
    _analyzeButton;

    constructor() {
        // console.log('KillboardClipboard loaded');
    }

    initialize() {
        // console.log('KillboardClipboard initialized');
        this._zkillButton = document.getElementById('zkill');
        this._analyzeButton = document.getElementById('analyze');



        this._zkillButton.addEventListener('click', (event) => {
            this.openZkillboardTab();
        })

        this._analyzeButton.addEventListener('click', (event) => {
            this.getZkillCharacterStats();
        });


        this.getZkillCharacterStats(this._analyzeButton);
    }

    async getZkillCharacterStats() {

        // refresh toutss
        let truc = await this.getCharacterIdFromESI();
        console.log(truc);


    }

    async getCharacterIdFromESI() {
        let text = await navigator.clipboard.readText()

        let names = JSON.stringify([text]);

        return await fetch("https://esi.evetech.net/latest/universe/ids/?datasource=tranquility&language=en",
        {
            method: "POST",
            body: names,
            headers: {
                'Content-Type': 'application/json'
            },

        }).then(res => { console.log(res); return res.json(); })
        .then(data => {
            return data.characters[0].id;
        });
    }

    openZkillboardTab(element) {
        //element.addEventListener('click', (event) => {
        navigator.clipboard.readText()
        .then(text => {
            let names = JSON.stringify([text]);
            fetch("https://esi.evetech.net/latest/universe/ids/?datasource=tranquility&language=en",
            {
                method: "POST",
                body: names,
                headers: {
                    'Content-Type': 'application/json'
                },
            }).then(function(res){ return res.json(); })
            .then(function(data){
                return data.characters[0].id;
            }).then(function(characterId) {
                let zkillURL= 'https://zkillboard.com/character/' + characterId + '/';
                window.open(zkillURL, '_blank');
            })
        });
        //})
    }

    // getZkillCharacterStats(element) {
    //     element.addEventListener('click', (event) => {
    //         fetch('https://zkillboard.com/api/stats/characterID/' + 1294095600 +'/')
    //             .then(function(res){ return res.json(); })
    //             .then(function (data) {
    //             console.log(data);
    //         }) 
    //     })
    // }





}