class FavoriteSolarSystemManager
{
    _solarSystemRepository;
    _buttonsParent;

    constructor(solarSystemRepository) {
        this._solarSystemRepository = solarSystemRepository
        this._buttonsParent = document.querySelector('.solar-system-list');
        this._favoriteListDiv = document.querySelector('.dashboard-system-list');;
    }

    initialize () {
        let observer = new MutationObserver(() => {this.observerCallback()});
        let config = { childList: true };
        observer.observe(this._buttonsParent, config);

        this.displayFavoriteSolarSystem();
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
        this.dynamicallyAddNewFavoriteSolarSystemToList(event);
    }

    displayFavoriteSolarSystem() {
        this._solarSystemRepository.getFavoriteSolarSystem().then((solarSystemPromiseList)=> {

            // console.log(solarSystemPromiseList);

            return Promise.all(solarSystemPromiseList).then((solarSystems) => {

                for(let solarSystem of solarSystems) {

                    let button = document.createElement('button');
                    button.setAttribute('class', 'btn btn-secondary favorite-solar-system');
                    button.setAttribute('type', 'button');
                    button.setAttribute('data-system-universe-id', solarSystem.getUniverseId());
                    // button.setAttribute('data-system-security-status', solarSytem.getSecurityStatus());
                    button.setAttribute('data-system-name', solarSystem.getName());
                    let textNode = document.createTextNode(solarSystem.getName());
                    button.appendChild(textNode);
                    this._favoriteListDiv.appendChild(button);

                }
            })

        })
    }

    dynamicallyAddNewFavoriteSolarSystemToList(event) {

        const solarSystemUniverseId = event.target.dataset['systemUniverseId'];
        const solarSystemName = event.target.dataset['systemName'];

        let button = document.createElement('button');
        button.setAttribute('class', 'btn btn-secondary favorite-solar-system');
        button.setAttribute('type', 'button');
        button.setAttribute('data-system-universe-id', solarSystemUniverseId);
        // button.setAttribute('data-system-security-status', solarSytem.getSecurityStatus());
        button.setAttribute('data-system-name', solarSystemName);
        let textNode = document.createTextNode(solarSystemName);
        button.appendChild(textNode);
        this._favoriteListDiv.appendChild(button);
    }

}
