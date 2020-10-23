class InGameSetDestination
{
    endPoints = {
        setDestination : '/api/character/set_destination/'
    }
    
    initialize() {
        console.log('SetDestination initilized')
        // TODO attach event listener on solar system favorite buttons
    }
    
    // TODO handler for solar system favorite button


    
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