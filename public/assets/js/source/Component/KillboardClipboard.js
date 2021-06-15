class KillboardClipboard {

    _zkillButton;
    _analyzeButton;
    // _shipsData;


    constructor() {
        this._zkillButton = document.getElementById('zkill');
        this._analyzeButton = document.getElementById('analyze');
    }

    initialize() {
        this._zkillButton.addEventListener('click', (event) => {
            this.openZkillboardTab();
        })
        this._analyzeButton.addEventListener('click', (event) => {
            this.displayCharacterStatsInTable();
        });

        // On charge la liste des ships si elle n'est pas déjà présente dans le session storage
        if (!sessionStorage.getItem('shipsData')) {
            this.getAllShipInfo();
            console.log('shipData loaded in session storage');
        }
    }

    openZkillboardTab() {
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
    }


    // Utils
    async getZkillCharacterStats() {
        let character = await this.getCharacterFromESI();
        return await fetch('https://zkillboard.com/api/stats/characterID/' + character.id +'/')
            .then(function(res){ return res.json(); })
            .then(function (characterStats) {
                return characterStats;
            }) 
    }

    async getCharacterFromESI() {
        let clipboardContent = await navigator.clipboard.readText()
        let names = JSON.stringify([clipboardContent]);
        return await fetch("https://esi.evetech.net/latest/universe/ids/?datasource=tranquility&language=en",
        {
            method: "POST",
            body: names,
            headers: {
                'Content-Type': 'application/json'
            },
        }).then(res => { return res.json(); })
        .then(data => {
            return data.characters[0];
        });
    }

    async getAllianceName(allianceID) {
        return await fetch('https://esi.evetech.net/latest/alliances/' + allianceID + '/?datasource=tranquility')
            .then(function(res){ return res.json(); })
            .then(function (alliance) {
                console.log(alliance);
                return alliance.name;
            }) 
    }

    async getCorpName(corpID) {
        return await fetch('https://esi.evetech.net/latest/corporations/' + corpID + '/?datasource=tranquility')
            .then(function(res){ return res.json(); })
            .then(function (corp) {
                console.log(corp);
                return corp.name;
            }) 
    }

    /**
     * On récupère les noms de tous les ships et leurs ids
     * Si ils ont déjà été appeler on les récupère directement dans le session storage
     */
    async getAllShipInfo () {
        // if (sessionStorage.getItem('shipsData')) {
        //     console.log('shipsData from session storage');
        //     return JSON.parse(sessionStorage.getItem('shipsData'));
        // }

        return await fetch('https://esi.evetech.net/v1/insurance/prices/?datasource=tranquility&language=en')
        .then(function(res){ return res.json(); })
        .then(function (data) {
            let allShipID = []
            for (let shipData of data) {
                allShipID.push(shipData.type_id);
            }
            return allShipID;
        })
        // on va récup tout les noms des ships à partir des ID
        .then(shipIdArray => {
            let shipIds = JSON.stringify(shipIdArray);
            return fetch("https://esi.evetech.net/v2/universe/names/?datasource=tranquility&language=en",
            {
                method: "POST",
                body: shipIds,
                headers: {
                    'Content-Type': 'application/json'
                },
            }).then(res => { return res.json(); })
            .then(data => {
                sessionStorage.setItem('shipsData', JSON.stringify(data));
                return data;
            });
        })
    }

    async displayCharacterStatsInTable () {
        // On récupère les données du perso
        let characterData = await this.getZkillCharacterStats();
        // On en fait ce qu'on veut
        console.log(characterData);


        let template = document.querySelector('#display-template');
        let tbody = document.querySelector('tbody');
        let clone = document.importNode(template.content, true);
        let td = clone.querySelectorAll('td');
        td[0].textContent = characterData.info.name
        td[1].textContent = characterData.dangerRatio
        td[2].textContent = await this.getAllianceName(characterData.info.allianceID);
        td[3].textContent = await this.getCorpName(characterData.info.corporationID);
        tbody.appendChild(clone);

        // On affiche la div portant le tableau
        let tableDisplayDiv = document.getElementById('display-table');
        tableDisplayDiv.style.display = 'block';


    }


}