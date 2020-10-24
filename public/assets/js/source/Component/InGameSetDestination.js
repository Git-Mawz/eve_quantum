class InGameSetDestination
{

    endPoints = {
        setDestination : '/api/character/set_destination/'
    }
    
    initialize() {
        console.log('SetDestination initilized')
        document.addEventListener('click', (event) => this.handleClickOnFavoriteSystem(event));
    }
    
    // TODO handler for solar system favorite button
    handleClickOnFavoriteSystem(event) {
        const eventTargetClasses = event.target.className;
        // console.log(eventTargetClasses);
        // console.log(eventTargetClasses.search(/favorite-solar-system/));
        if (eventTargetClasses.search(/favorite-solar-system/) != -1) {
            this.setDestination(event.target.dataset.systemUniverseId);
        }
    }


    
    setDestination(solarSystemUniverseId) {
        
        let options = {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            mode: 'cors',
            cache: 'no-cache'
        };
        
        fetch(this.endPoints.setDestination + solarSystemUniverseId, options)
        .then((response) => {
            console.log(response);
        });
        
    }
}