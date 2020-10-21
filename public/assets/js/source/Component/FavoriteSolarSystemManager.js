class FavoriteSolarSystemManager
{
    _manager;
    _buttonsParent;

    constructor(manager) {
        this._manager = manager
        this._buttonsParent = document.querySelector('.solar-system-list');
    }

    initialize () {
        let observer = new MutationObserver(() => {this.observerCallback()});
        let config = { childList: true };
        observer.observe(this._buttonsParent, config);

        this.displayFavoriteSolarSystems();
    }

    // Methods to add solar system to favorite
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

        // console.log(solarSystemUniverseId);
        // console.log(solarSystemName);

        this._manager.addSolarSystemToFavorite(solarSystemUniverseId, solarSystemName);
    }

    displayFavoriteSolarSystems () {
       this._manager.getFavoriteSolarSystem()
    }

}
