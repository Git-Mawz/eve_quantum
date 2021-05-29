class KillboardClipboard {

    constructor() {
        // console.log('KillboardClipboard loaded');
    }

    initialize() {
        // console.log('KillboardClipboard initialized');
        let button = document.getElementById('local-spy');
        this.openZkillboardTab(button);
        
    }

    openZkillboardTab(element) {
        element.addEventListener('click', (event) => {
            navigator.clipboard.readText()
            .then(text => {
                let names = JSON.stringify([text]);
                fetch("https://esi.evetech.net/latest/universe/ids/?datasource=tranquility&language=en",
                {
                    method: "POST",
                    body: names
                })
                .then(function(res){ return res.json(); })
                .then(function(data){
                    return data.characters[0].id;
                }).then(function(charId) {
                    let zkillURL= 'https://zkillboard.com/character/' + charId + '/';
                    window.open(zkillURL, '_blank');
                })
            }); 
        })
    }
}