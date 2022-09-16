import { ethers } from "ethers";
const platContractABI = require('../../../data/tasks.json')['abi'];
const platContractAddress = "0x6E440d515E0ddE78de24245d57dF1790fA41eFc4";
const tokenContractABI = require('../../../data/platToken.json')['abi'];
const tokenContractAddress = "0x0AE40ea79F109E7D78dDfaA366e1372c3A214ef0";


class Deposit {
    
    constructor() {
        const _this = this;
        ;(async function () {
            try {
                await _this.isConnected();
            } catch (e) {
                console.log('err 18', e);
                return true;
            }
        }());
    }
    /**
     *
     * @returns {Promise<boolean>}
     * @private
     */
    _makeTransaction() {
        const _this = this;
        //Show message box
        $('#deposit_process').show();
        //Start deposit
        ;(async function () {
            const provider = new ethers.providers.Web3Provider(window.ethereum, "any");
            console.log(provider);
            // get a signer wallet!
            const signer = provider.getSigner();

            let platContract = new ethers.Contract(platContractAddress, platContractABI, signer)
            //CAMPAIGN_AMOUNT
            let depositValue = ethers.utils.parseEther("1000");
            let taskId = TASK_ID;

            //TODO: Change wallet. Default 0
            await platContract.connect(signer).createCampaign(taskId, depositValue);
            // let tokenContract = new ethers.Contract(tokenContractAddress, tokenContractABI, signer);
            // await tokenContract.connect(signer).approve("0x0C4D42B9BCA84e6aA29bf94dA184b06F56C436b1", depositValue);
            console.log(res);
            return true;
        }());
    }

    /**
     *
     * @returns boolean
     * @private
     */
    async _connectWS() {
        return true;
    }

    /**
     *
     * @returns boolean
     * @private
     */
    async isConnected() {
        const accounts = await ethereum.request({method: 'eth_accounts'});       
        if (accounts.length) {
            this._makeTransaction();
           console.log(`You're connected to: ${accounts[0]}`);
           return true;
        } else {
           console.log("Metamask is not connected");
        }

        return false;
     }

    /**
     *
     * @returns {Promise<boolean>}
     * @private
     */
    async _web3Enabled() {
        return await web3Enable('plats-action-hub').then(extensions => {
            if (extensions.length <= 0) {
                this._showErr('Plugin not found', 'Hãy cài đặt plugin');

                throw Error('');
            }

            return true;
        });
    }

    /**
     *
     * @private
     */
    _showErr(title, message) {
        $('.js-error-title').text(title);
        $('.js-error-message').text(message);
        $('#err_box').show();
        $('#deposit_process').hide();
    }
}

$(document).ready(function () {
   new Deposit();
   // main();
});
