class SolarSystem {

    _data;

    loadData(data) {
        this._data = data;
        return this;
    }

    getData() {
        return this._data;
    }
    
    getName() {
        return this._data.name;
    }

    getSecurityStatus() {
        return this._data.security_status;
    }

    getUniverseId() {
        return this._data.system_id;
    }

    getConstellationId() {
        return this._data.constellation_id;
    }

}
