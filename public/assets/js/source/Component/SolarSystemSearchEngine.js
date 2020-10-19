
class SolarSystemSearchEngine

{
    _baseUrl;
    _form;
    _input;
    _manager;
    _ul;

    constructor(baseUrl, form, input, manager) {
        this._baseUrl = baseUrl;
        this._form = form;
        this._input = input;
        this._manager = manager;
        this._ul = document.querySelector('.solar-system-list');
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

        if (this._input.value.length > 2) {
            this._manager.searchSolarSystem(this._input.value).then((promiseList) => {    
                this._ul.innerHTML = '';
                return Promise.all(promiseList).then((responses) => {
                    const solarSytems = responses;
                    // console.log(solarSytems)
                    for (let solarSytem of solarSytems) {
                        // console.log(solarSytem.getName());
                        this.makeSolarSystemList(solarSytem);
                    } 
                })
            }); 
        }
            
    }

    makeSolarSystemList(solarSytem) {

        console.log(solarSytem);

        let li = document.createElement('li');
        let textNode = document.createTextNode(solarSytem.getName());
        li.appendChild(textNode);

        this._ul.appendChild(li);

    }



}