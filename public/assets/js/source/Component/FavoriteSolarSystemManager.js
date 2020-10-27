class FavoriteSolarSystemManager
{
    _solarSystemRepository;
    _buttonsParent;

    constructor(solarSystemRepository) {
        this._solarSystemRepository = solarSystemRepository;
        this._buttonsParent = document.querySelector('.solar-system-list');
        this._favoriteListDiv = document.querySelector('.dashboard-system-list');
    }

    initialize () {
        let observer = new MutationObserver(() => {this.observerCallback()});
        let config = { childList: true };
        observer.observe(this._buttonsParent, config);

        this.displayFavoriteSolarSystem();


        // ! Drag and drop

        let buttonLoadedObserver = new MutationObserver(() => {this.buttonLoadedObserverCallback()});
        buttonLoadedObserver.observe(this._favoriteListDiv, config);

        const trashButton = document.getElementById('drop-target');
        console.log(trashButton);
        trashButton.addEventListener('drop', (event) => {this.handleDrop(event)});
        trashButton.addEventListener('dragover', (event) => {this.handleDragOver(event)});


        // ! Drag and drop

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
                    // ! drag and drop
                    button.setAttribute('draggable', true);
                    // ! drag and drop
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



    // ! drag and drop

    buttonLoadedObserverCallback() {
        console.log('buttonLoadedObserverCallback');
        let favoriteSystems = document.querySelectorAll('.favorite-solar-system');
        for (let favoriteSystem of favoriteSystems) {
            // console.log(favoriteSystem);
            favoriteSystem.addEventListener('dragstart', (event) => {this.handleDragStart(event)});
        }
    }

    handleDragStart(event) {
        console.log('drag start')
        event.dataTransfer.setData('system-id', event.target.dataset.systemUniverseId);
        event.dataTransfer.dropEffect = 'move';
    }

    handleDragOver(event) {
        event.preventDefault();
        console.log('drag over')
        event.dataTransfer.dropEffect = 'move';
    }

    handleDrop(event) {
        event.preventDefault();
        let systemId = event.dataTransfer.getData('system-id');
        console.log(systemId)

        // this._favoriteListDiv
        this._solarSystemRepository.removeFavoriteSolarSystem(systemId)
    }


    // ! drag and drop

}
