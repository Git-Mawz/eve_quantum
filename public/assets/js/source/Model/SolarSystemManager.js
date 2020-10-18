console.log("SolarSystemManager.js loaded");
class SolarSystemManager
{
    endPoints = {
        searchSolarSystem: 'https://esi.evetech.net/latest/search/?categories=solar_system&datasource=tranquility&language=en-us&strict=false&search=' ,
        searchSolarSystemName: 'https://esi.evetech.net/latest/universe/systems/'
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

            let solarSystemsArray = [];

            for (let solarSystemId of solarSystemsIds) {
                // console.log(solarSystemId);
                fetch(this.endPoints.searchSolarSystemName + solarSystemId).then((response) =>{
                    return response.json();
                }).then((data) => {
                    const solarSystemData = data;
                    // console.log(solarSystemData);
                    const solarSystem = new SolarSystem();
                    solarSystem.loadData(solarSystemData)
                    solarSystemsArray.push(solarSystem);
                    // console.log(solarSystem.getName());
                })
            }
            // console.log(solarSystemsArray);
            return solarSystemsArray;

        });






    }

    
}