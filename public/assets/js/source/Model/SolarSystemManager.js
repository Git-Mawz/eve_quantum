console.log("SolarSystemManager.js loaded");
class SolarSystemManager
{
    endPoints = {
        searchSolarSystem: 'https://esi.evetech.net/latest/search/?categories=solar_system&datasource=tranquility&language=en-us&strict=false&search=' ,
        getSearchSolarSystemName: 'https://esi.evetech.net/latest/universe/systems/'
      };

    searchSolarSystem(search) {
        return fetch(this.endPoints.searchSolarSystem + search).then((response) => {
            return response.json()
        }).then((rawData) => {
            // console.log(rawData);
            return rawData.solar_system;
        }).then((solarSystemsIds) => {
            // console.log(solarSystemsIds);
            for (let solarSystemId of solarSystemsIds) {
                // console.log(solarSystemId);
                fetch(this.endPoints.getSearchSolarSystemName + solarSystemId).then((response) =>{
                    return response.json();
                }).then((rawData) => {
                    console.log(rawData);
                })
            }

        });






    }

    
}