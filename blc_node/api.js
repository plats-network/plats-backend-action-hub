import {web3Accounts, web3Enable, web3FromSource} from "@polkadot/extension-dapp";
import {Keyring} from "@polkadot/api";

const main = async () => {
    /*    const provider = new WsProvider(wsHost);
        const api = await ApiPromise.create({provider});*/



// returns an array of all the injected sources
// (this needs to be called first, before other requests)
    const allInjected = await web3Enable('plats-action-hub');

    console.log(allInjected);
// returns an array of { address, meta: { name, source } }
// meta.source contains the name of the extension that provides this account
    const allAccounts = await web3Accounts();
    console.log(allAccounts);
    // create campaign
    /// Parameter:
    /// + who: everyone ->sign this extrinsic
    /// + value: amount of token for this campaign
// account is of type InjectedAccountWithMeta
// We arbitrarily select the first account returned from the above snippet
    const account = allAccounts[0];

// here we use the api to create a balance transfer to some account of a value of 12344
    const transferExtrinsic = api.tx.task.createCampaign(100000);
    //Số tiền,

    //{
    //        'amount' : 'sdsad',
    //        'task_id': 'ssadasd'
    //     }

// to be able to retrieve the signer interface from this account
// we can use web3FromSource which will return an InjectedExtension type
    const injector = await web3FromSource(account.meta.source);

// passing the injected account address as the first argument of signAndSend
// will allow the api to retrieve the signer and the user will see the extension
// popup asking to sign the balance transfer transaction

    transferExtrinsic.signAndSend(account.address, {signer: injector.signer}, ({status}) => {

        console.log(status);


        if (status.isInBlock) {
            console.log('ok');
        } else {
            console.log('Err');
        }
    }).catch((error) => {
        console.log(':( transaction failed', error);
    });

    return;

    //Phần này là của backend server

    //Phần reward
    const PHRASE_ROOT = 'fish dash budget stairs hire reason mention forest census copper kid away'; // giấu cái này đi nhá!
    // Để nguyên

    const keyring = new Keyring({type: 'sr25519'});
    const ROOT = keyring.addFromUri(PHRASE_ROOT);
    const users = ["5HMabVtSJsRrL2756NFeC269Bf5EmZm1zH21TvewmneaCZk5"];//ví của user nhận thưởng

    /*const unsub3 = await api.tx.sudo
        .sudo(
            api.tx.task.payment(0,users,10000 )
            //O; ID của task

        )
        .signAndSend(ROOT, (result) => {
            console.log(result);
            //chỗ này vẫn phải chờ?
            if (result.status.isFinalized) {
                console.log('ok');
                console.log("Sudo key reward this campaign");
                unsub3();
            }

        });*/


    //Phân claim
    // Chỗ comment này là đã khai báo phía bên trên nhé!

    /*const PHRASE_ROOT = 'fish dash budget stairs hire reason mention forest census copper kid away';
    const keyring = new Keyring({ type: 'sr25519' });
    const ROOT = keyring.addFromUri(PHRASE_ROOT);
    const users = ["5HMabVtSJsRrL2756NFeC269Bf5EmZm1zH21TvewmneaCZk5"]*/

    // Chỗ comment này là đã khai báo phía bên trên nhé!

    /* const unsub4 = await api.tx.sudo
         .sudo(
             api.tx.task.claim(0,10000, '5HMabVtSJsRrL2756NFeC269Bf5EmZm1zH21TvewmneaCZk5')
         )
         .signAndSend(ROOT, (result) => {
         console.log(result);
             if (result.status.isFinalized) {
                 console.log('ok');
                 console.log("Sudo key reward this campaign");
                 unsub4();
             }

         });*/

};

