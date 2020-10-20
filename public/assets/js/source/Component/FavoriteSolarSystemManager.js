class FavoriteSolarSystemManager
{
    _manager;
    _buttonsParent;

    constructor(manager) {
        this._manager = manager
        this._buttonsParent = document.querySelector('.solar-system-list');
    }

    // ! travail initial

    // initialize() {
    //     console.log('FavoriteSolarSystemManager initialized');

    //     let config = { childList: true };

    //     let callback = function(manager) {

    //         let buttons = document.querySelectorAll('.found-solar-system');
    //         // console.log(buttons);
    //         for (let button of buttons) {
    //             console.log(button);
    //             button.addEventListener('click', handleClickOnSolarSystemButton);
    //         }

    //         function handleClickOnSolarSystemButton (event) {

    //             console.log(event);
                
    //             const solarSystemUniverseId = event.target.dataset['systemId'];
    //             const solarSystemName = event.target.dataset['systemName'];
        
    //             console.log(solarSystemUniverseId);
    //             console.log(solarSystemName);

    //             console.log(manager);
        
    //         }

    //     };

    //     let observer = new MutationObserver(callback);
    //     observer.observe(this._buttonsParent, config);
    // }

    // handleClickOnSolarSystemButton(event) {

    //     console.log(event);
        
    //     const solarSystemUniverseId = event.target.dataset['systemId'];
    //     const solarSystemName = event.target.dataset['systemName'];

    //     console.log(solarSystemUniverseId);
    //     console.log(solarSystemName);

    // }


    // ! test 

    initialize () {
        let observer = new MutationObserver(() => {this.observerCallback()});
        let config = { childList: true };
        observer.observe(this._buttonsParent, config);
    }

    observerCallback () {

        let buttons = document.querySelectorAll('.found-solar-system');
        // console.log(buttons);
        for (let button of buttons) {
            button.addEventListener('click', (event) => {this.handleClickOnSolarSystemButton(event)});
        }
    }

    handleClickOnSolarSystemButton (event) {
        console.log(event);
        
        const solarSystemUniverseId = event.target.dataset['systemId'];
        const solarSystemName = event.target.dataset['systemName'];

        console.log(solarSystemUniverseId);
        console.log(solarSystemName);

        this._manager.addSolarSystemToFavorite(solarSystemUniverseId, solarSystemName);
    }

}
