import { ethers } from "ethers";
import TronWeb from 'tronweb';
const tokenContractAddress = "TEVDdsSRWxpPXv1JwGQ2V3ExrRyScpmQPe";
const tasksContractAddress = "TNeUyFA6ZdeC8JCCma4UQuAEHTfPmx9WYE";
class Deposit {
    
    constructor() {
        const _this = this;
        ;(async function () {
            try {
                await _this._makeTransaction();
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
            //CAMPAIGN_AMOUNT
            let taskId = TASK_ID;
            let contract = await _this.getContractTasks();
            if (contract) {
                let depositValue = window.tronWeb.toBigNumber('50000000000000000000').toString();
                contract.createCampaign(taskId, depositValue).send({
                    feeLimit: 100_000_000,
                }).then((data) => {
                    console.log(data);
                })
            }
            else {
                console.log("No contract task")
                window.location.href = "/cp/tasks";
            }
            return true;
        }());
    }

    /**
     *
     * @returns {Promise<boolean>}
     * @private
     */
    walletInstalled(){
        if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
            return true;
        } else {
            return false;
        } 
    }

    /**
     *
     * @returns {Promise<boolean>}
     * @private
     */
    connectWallet() {
        $('#connectWallet').on('click', () => {
            console.log('connectWallet');
        })
    }

    /**
     *
     * @returns {Promise<boolean>}
     * @private
     */
    async getContractTasks(){
        if(this.walletInstalled()){
            return window.tronWeb.contract().at(tasksContractAddress);
        }
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
