class FavoriteSolarSystemManager
{
    _solarSystemRepository;
    _buttonsParent;

    constructor(solarSystemRepository) {
        this._solarSystemRepository = solarSystemRepository
        this._buttonsParent = document.querySelector('.solar-system-list');
    }

    initialize () {
        let observer = new MutationObserver(() => {this.observerCallback()});
        let config = { childList: true };
        observer.observe(this._buttonsParent, config);

        // this.displayFavoriteSolarSystems();
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
        
        const solarSystemUniverseId = event.target.dataset['systemUniverseId'];
        const solarSystemName = event.target.dataset['systemName'];

        this._solarSystemRepository.addSolarSystemToFavorite(solarSystemUniverseId, solarSystemName);
    }

}
