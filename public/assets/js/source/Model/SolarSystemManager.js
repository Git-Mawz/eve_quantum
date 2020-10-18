console.log("SolarSystemManager.js loaded");
class SolarSystemManager
{
    endPoints = {
        searchSolarSystem: 'https://esi.evetech.net/latest/search/?categories=solar_system&datasource=tranquility&language=en-us' + '&strict=false' + '&search=' ,
      };

    searchSolarSystem(input) {
        return fetch(this.endPoints.searchSolarSystem + input).then((response) => {
            return response.json()
        }).then((rawData) => {
            console.log(rawData);
        })
    }
    
}