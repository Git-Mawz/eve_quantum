class FavoriteSolarSystemManager
{
    _baseUrl;
    _manager;
    _buttonsParent;

    constructor(baseUrl, manager) {

        this._baseUrl = baseUrl;
        this._manager = manager
        this._buttonsParent = document.querySelector('.solar-system-list');

    }

    initialize() {
        // console.log('FavoriteSolarSystemManager initialized');

        if (this._buttonsParent.addEventListener) {
            parent.addEventListener('click', this.handleClick, false);
        }else if (this._buttonsParent.attachEvent) {
            parent.attachEvent('onclick', this.handleClick);
        }

    }

    handleClick(event) {
        
        const solarSystemUniverseId = event.target.dataset['systemId'];
        const solarSystemName = event.target.dataset['systemName'];


        

    }




}
