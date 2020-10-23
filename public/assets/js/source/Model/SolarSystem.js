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
        // patch to either match with solar system coming for Eve Online API or Eve Quantum API
        if (typeof this._data.system_id === 'undefined') {
            return this._data.universeId;
        }
        return this._data.system_id;
    }

    getConstellationId() {
        return this._data.constellation_id;
    }

}
