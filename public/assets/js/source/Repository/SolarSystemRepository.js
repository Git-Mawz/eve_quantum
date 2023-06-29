console.log("SolarSystemRepository.js loaded");
class SolarSystemRepository
{

    endPoints = {
        // searchSolarSystem: 'https://esi.evetech.net/latest/search/?categories=solar_system&datasource=tranquility&language=en-us&strict=false&search=',
        searchSolarSystem: 'https://esi.evetech.net/latest/characters/469708989/search/?categories=solar_system&datasource=tranquility&language=en&strict=false&search=',
        searchSolarSystemName: 'https://esi.evetech.net/latest/universe/systems/',

        addSystemToFavorite: '/api/character/solar_system',
        getFavoriteSolarSystem: '/api/character/solar_system',
        removeFavoriteSolarSystem: '/api/character/solar_system/'

    };

    searchSolarSystem(search) {

        return fetch(this.endPoints.searchSolarSystem + search).then((response) => {
            return response.json()
        }).then((rawData) => {
            console.log(rawData);
            let solarSystemsIds = rawData.solar_system;
            return solarSystemsIds;
        }).then((solarSystemsIds) => {
            // console.log(solarSystemsIds)
            let promiseList = [];
            for (let solarSystemId of solarSystemsIds) {
                let promise = this.searchSystemById(solarSystemId);
                promiseList.push(promise);
            }
            // console.log(solarSystemsArray);
            return promiseList;

        }).catch((error) => {
            console.log(error);
            console.log('No solar system found');
        });
    }

    searchSystemById(solarSystemId) {
        // console.log(solarSystemId);
        return fetch(this.endPoints.searchSolarSystemName + solarSystemId).then((response) =>{
            return response.json();
        }).then((data) => {
            // console.log(data);
            const solarSystem = new SolarSystem();
            solarSystem.loadData(data);
            return solarSystem;
        })
    }

    addSolarSystemToFavorite(solarSystemUniverseId, solarSystemName) {

        // console.log(solarSystemUniverseId);
        // console.log(solarSystemName);

        let options = {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'systemName': solarSystemName,
                'systemUniverseId': solarSystemUniverseId
            }),
            mode: 'cors',
            cache: 'no-cache'
        };

        fetch(this.endPoints.addSystemToFavorite, options)
        .then((response) => {
            console.log(response);
        })
    }

    getFavoriteSolarSystem()
    {
        return fetch(this.endPoints.getFavoriteSolarSystem)
        .then((response)=> {
            return response.json()
        }).then((rawData) => {

            const solarSystems = rawData.solarSystems;
            let solarSystemList = [];

            for(let data of solarSystems) {
                const solarSystem = new SolarSystem();
                solarSystem.loadData(data);
                solarSystemList.push(solarSystem);
            }
            // console.log(solarSystemList);
            return solarSystemList;
        })
    }

    removeFavoriteSolarSystem(solarSystemUniverseId)
    {
        let options = {
            method: 'DELETE',
            mode: 'cors',
            cache: 'no-cache'
        };

        fetch(this.endPoints.removeFavoriteSolarSystem + solarSystemUniverseId, options)
        .then((response) => {
            console.log(response);
        })
    }

   
}
