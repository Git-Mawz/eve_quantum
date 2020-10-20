console.log("SolarSystemManager.js loaded");
class SolarSystemManager
{

    endPoints = {
        searchSolarSystem: 'https://esi.evetech.net/latest/search/?categories=solar_system&datasource=tranquility&language=en-us&strict=false&search=' ,
        searchSolarSystemName: 'https://esi.evetech.net/latest/universe/systems/',

        // addSystemToFavorite: baseUrl + '/api/character/solar_system'

      };

    searchSolarSystem(search) {

        return fetch(this.endPoints.searchSolarSystem + search).then((response) => {
            return response.json()
        }).then((rawData) => {
            // console.log(rawData);
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
            console.log('No solar system found');
        });
    }

    searchSystemById(solarSystemId) {
        // console.log(solarSystemId);
        return fetch(this.endPoints.searchSolarSystemName + solarSystemId).then((response) =>{
            return response.json();
        }).then((data) => {
            // console.log(solarSystemData);
            const solarSystem = new SolarSystem();
            solarSystem.loadData(data);
            return solarSystem;
        })
    }

    // addSolarSystemToFavorite(baseUrl, manager, solarSystemId, solarSystemName) {



    // }

    
}
