/*

function parseXml(xml) {
    var dom = null;
    if (window.DOMParser) {
        try {
            dom = (new DOMParser()).parseFromString(xml, "text/xml");
        }
        catch (e) { dom = null; }
    }
    else if (window.ActiveXObject) {
        try {
            dom = new ActiveXObject('Microsoft.XMLDOM');
            dom.async = false;
            if (!dom.loadXML(xml)) // parse error ..

                window.alert(dom.parseError.reason + dom.parseError.srcText);
        }
        catch (e) { dom = null; }
    }
    else
        alert("cannot parse xml string!");
    return dom;
}

/!*
xml2json("source/bookStore.xml");*!/

function cambiarFile(){
    const input = document.getElementById('fileToConvert');
    if(input.files && input.files[0])
        console.log("File Seleccionado : ", input.files[0]);

}
console.log("Sin Archivo Seleccionado " + document.getElementById('inputFileServer').files[0]);*/
