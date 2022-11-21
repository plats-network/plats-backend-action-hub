import { throws } from "assert";
import {utils} from "near-api-js";

export class Payment {
    constructor({contractId, wallet}) {
        this.contractId = contractId;
        this.wallet = wallet;
    }

    async deposit(taskId, amount) {
        return await this.wallet.callMethod({
            contractId: this.contractId,
            method: "deposit",
            args: {
                task_id: taskId,
                amount: amount
            },
            deposit: utils.format.parseNearAmount("0.01") // Deposit 0.01 NEAR
        })
    }
    async ftOnTrasfer(senderId, amount, msg) {
        return await this.wallet.callMethod({
            contractId: this.contractId,
            method: "ft_on_transfer",
            args: {
                sender_id: senderId,
                amount: amount,
                msg: msg,
            },
        })
    }
    async rewardUser(taskId, userId, amountRewardUser) {
        return await this.wallet.callMethod({
            contractId: this.contractId,
            method: "reward",
            args: {
                task_id: taskId,
                user_id: userId,
                amount_reward_user: amountRewardUser,
            },
        })
    }
    async getTotalDeposit(taskId) {
        return await this.wallet.viewMethod({
            contractId: this.contractId,
            method: "get_total_deposit",
            args: {
            task_id: taskId
            }
        })
    }
}
// ABI