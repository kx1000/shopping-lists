import { Controller } from 'stimulus';
import init from "../init";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "main" comes from the filename:
 * main_controller.js -> "main"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        this.element.addEventListener('swup:connect', this._onConnect);
    }

    disconnect() {
        this.element.removeEventListener('swup:connect', this._onConnect);
    }

    _onConnect(event) {
        event.detail.swup.on('contentReplaced', init.init);
    }
}
