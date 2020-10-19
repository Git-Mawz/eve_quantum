
class SolarSystemSearchEngine

{
    _baseUrl;
    _form;
    _input;
    _manager;
    _resultDiv;
    _resultDivText;

    constructor(baseUrl, form, input, manager) {
        this._baseUrl = baseUrl;
        this._form = form;
        this._input = input;
        this._manager = manager;
        this._resultDiv = document.querySelector('.solar-system-list');
        this._resultDivText = document.querySelector('.solar-system-result-text');
      }

    initialize() {
        console.log('initialize SolarSystemSearchEngine');
        // console.log(this._form);
        // console.log(this._input);
        this._form.addEventListener('submit', (event) => {this.handleSubmit(event)})
    }

    handleSubmit(event) {
        event.preventDefault();
        // console.log('prevent default OK');

        
        if (this._input.value.length > 2) {
            this._manager.searchSolarSystem(this._input.value).then((promiseList) => {
                // Init of ul to display new results 
                this._resultDiv.innerHTML = '';
                this._resultDivText.innerHTML = '<p> Cliquez sur un système pour l\'ajouter à vos favoris et ainsi pouvoir définir votre destination in-game en cliquant dessus <br> Résultat : </p>'

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

        let button = document.createElement('button');
        button.setAttribute('class', 'btn btn-secondary');
        button.setAttribute('type', 'button');
        button.setAttribute('data-system-id', solarSytem.getSystemId());
        button.setAttribute('data-security-status', solarSytem.getSecurityStatus());
        let textNode = document.createTextNode(solarSytem.getName());
        button.appendChild(textNode);
        this._resultDiv.appendChild(button);
    }
}
