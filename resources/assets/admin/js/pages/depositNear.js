// NEAR
import { Wallet } from './nearWallet';
import { Payment } from './nearInterface';

const CONTRACT_ADDRESS = process.env.CONTRACT_NAME
console.log(CONTRACT_ADDRESS);

// When creating the wallet you can optionally ask to create an access key
// Having the key enables to call non-payable methods without interrupting the user to sign
const wallet = new Wallet({ createAccessKeyFor: process.env.CONTRACT_NAME });
const payment = new Payment({ contractId: process.env.CONTRACT_NAME, wallet });

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
            let isSignedIn = await wallet.startUp();
            if (isSignedIn) {
                $('#connectWallet').text(wallet.accountId)
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                
                if(!urlParams.get('transactionHashes')) {
                    await payment.deposit(taskId, "10000000000000000000");
                } else {
                    window.location.href = "/cp/tasks";
                }
            } else {
                $('#connectWallet').text('Connect wallet')
                wallet.signIn()
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
