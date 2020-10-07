class Question {

    _data;


    loadData(data) {
        this._data = data;
        return this;
    }

    getQuestion() {
        return this._data.title;
    }

    // foo() {
    //     /** ici du code */
    //     console.log('called foo');
    //     return this;
    // }

    // bar() {
    //     /** ici du code */
    //     console.log('called bar');
    //     return this;
    // }
}
