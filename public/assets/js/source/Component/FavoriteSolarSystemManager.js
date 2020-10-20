class FavoriteSolarSystemManager
{
    _manager;
    _buttonsParent;

    constructor(manager) {
        this._manager = manager
        this._buttonsParent = document.querySelector('.solar-system-list');
    }

    initialize() {
        console.log('FavoriteSolarSystemManager initialized');

        let config = { childList: true };

        let callback = function(mutationsList) {

            let buttons = document.querySelectorAll('.found-solar-system');
            // console.log(buttons);
            for (let button of buttons) {
                console.log(this.handleClick);
                // button.addEventListener('click', this.handleClick);
            }
        };

        let observer = new MutationObserver(callback);
        observer.observe(this._buttonsParent, config);
    }

    handleClick(event) {

        console.log(event);
        
        const solarSystemUniverseId = event.target.dataset['systemId'];
        const solarSystemName = event.target.dataset['systemName'];

        console.log(solarSystemUniverseId);
        console.log(solarSystemName);

    }




}
