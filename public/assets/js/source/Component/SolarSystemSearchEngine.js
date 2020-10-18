
class SolarSystemSearchEngine

{
    _baseUrl;
    _form;
    _input;
    _manager;

    constructor(baseUrl, form, input, manager) {
        this._baseUrl = baseUrl;
        this._form = form;
        this._input = input;
        this._manager = manager;
      }

    initialize() {
        console.log('initialize SolarSystemSearchEngine');
        // console.log(this._form);
        // console.log(this._input);
        this._form.addEventListener('submit', (event) => {this.handleSubmit(event)})
    }

    handleSubmit(event) {
        event.preventDefault();
        console.log('prevent default OK');
        this._manager.searchSolarSystem('nourvu');
    }


}