class BaseUrl {

    getBaseUrl() {

        let getUrl = window.location;

        let baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        return baseUrl;
    }
        
}