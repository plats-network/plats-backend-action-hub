$(document).ready(function () {
    GLOBAL_CONFIG.init();
});

const tokenContractAddress = "TEVDdsSRWxpPXv1JwGQ2V3ExrRyScpmQPe";

window.GLOBAL_CONFIG = function () {
    return {
        toggleBuilder : () => {
            $('[data-init-plugin="select2"]').each(function () {
                let config = {
                    theme: 'bootstrap4',
                    minimumResultsForSearch : -1,
                    disabled                : !!($(this).attr('readonly')),
                };

                $(this).select2(config);
            });

        },
        connectWallet(){
            $('#connectWallet').on('click', async () => {
                    let contract = await this.getContractToken();
                    let amountPlat = contract.balanceOf(window.tronWeb.defaultAddress.base58).call().then(function(data) {
                    let res = window.tronWeb.toDecimal(data["_hex"]);
                    
                    return res;
                });
                let amountPlatRes = await amountPlat;
                $('#connectWallet span').text(parseInt(amountPlatRes)/1000000000000000000 + ' PLT')
            })
            
        },

        async getContractToken(){
            if(this.walletInstalled()){
                return window.tronWeb.contract().at(tokenContractAddress);
            }
        },

        walletInstalled : () => {
            if (window.tronWeb && window.tronWeb.defaultAddress.base58) {
                return true;
            } else {
                return false;
            } 
        },

        init : function () {
            this.toggleBuilder();
            this.walletInstalled();
            this.getContractToken();
            this.connectWallet();
        }
    };
}();
