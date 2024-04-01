use {
    anchor_lang::{
        prelude::*,
        system_program,
    },
    anchor_spl::{
        associated_token,
        token,
    },
};

use crate::{
    states::{Pool},
    error::ErrorFactory,
};

impl ClaimNft<'_> {
    pub fn claim(
        ctx: Context<ClaimNft>,
    ) -> Result<()> {
        let signer_seeds: [&[&[u8]]; 1] = [&[
            b"state",
            &ctx.accounts.pool.seed.to_le_bytes()[..],
            &[ctx.accounts.pool.bump],
        ]];
        
        let sale_lamports = ctx.accounts.pool.price;
        if sale_lamports > 0 {
            msg!("Initiating transfer of {} lamports...", sale_lamports);
            require_keys_eq!(
                ctx.accounts.pool.initializer,
                ctx.accounts.fee_wallet.key(),
                ErrorFactory::MisMatchdFeeWalletAddress
            );
            msg!("Purchaser (sending lamports): {}", &ctx.accounts.buyer_authority.key());
            msg!("Seller (receiving lamports): {}", &ctx.accounts.pool.initializer);
            system_program::transfer(
                CpiContext::new(
                    ctx.accounts.system_program.to_account_info(),
                    system_program::Transfer {
                        from: ctx.accounts.buyer_authority.to_account_info(),
                        to: ctx.accounts.fee_wallet.to_account_info(),
                    }
                ),
                sale_lamports
            )?;
            
            msg!("Lamports transferred successfully.");
        }
    
        msg!("Creating buyer token account...");
        msg!("Buyer Token Address: {}", &ctx.accounts.buyer_token_account.key());    
        msg!("Transferring NFT...");
        msg!("Owner Token Address: {}", &ctx.accounts.pool_token_account.key());    
        msg!("Buyer Token Address: {}", &ctx.accounts.buyer_token_account.key());    
        token::transfer(
            CpiContext::new(
                ctx.accounts.token_program.to_account_info(),
                token::Transfer {
                    from: ctx.accounts.pool_token_account.to_account_info(),
                    to: ctx.accounts.buyer_token_account.to_account_info(),
                    authority: ctx.accounts.pool.to_account_info(),
                }
            ).with_signer(&signer_seeds),
            1
        )?;
        msg!("NFT transferred successfully.");

        msg!("Close pool token account...");
        msg!("Pool Token Address: {}", &ctx.accounts.pool_token_account.key()); 
        msg!("Closing...");
        token::close_account(
            CpiContext::new(
                ctx.accounts.token_program.to_account_info(),
                token::CloseAccount {
                    account: ctx.accounts.pool_token_account.to_account_info(),
                    destination: ctx.accounts.buyer_authority.to_account_info(),
                    authority: ctx.accounts.pool.to_account_info(),
                }
            ).with_signer(&signer_seeds)
        )?;
        msg!("Token address closed successfully.");
        msg!("Sale completed successfully!");
    
        Ok(())
    }

    // fn pay_fee(
    //     ctx: &Context<ClaimNft>,
    // ) -> Result<()> {
    //     let sale_lamports = ctx.accounts.pool.price;
    //     msg!("Initiating transfer of {} lamports...", sale_lamports);
    //     require_keys_eq!(
    //         ctx.accounts.pool.initializer,
    //         ctx.accounts.fee_wallet.key(),
    //         ErrorFactory::MisMatchdFeeWalletAddress
    //     );
    //     msg!("Purchaser (sending lamports): {}", &ctx.accounts.buyer_authority.key());
    //     msg!("Seller (receiving lamports): {}", &ctx.accounts.pool.initializer);
    //     system_program::transfer(
    //         CpiContext::new(
    //             ctx.accounts.system_program.to_account_info(),
    //             system_program::Transfer {
    //                 from: ctx.accounts.buyer_authority.to_account_info(),
    //                 to: ctx.accounts.fee_wallet.to_account_info(),
    //             }
    //         ),
    //         sale_lamports
    //     )?;
        
    //     msg!("Lamports transferred successfully.");
    //     Ok(())
    // }
}


#[derive(Accounts)]
pub struct ClaimNft<'info> {
    #[account(mut)]
    pub mint: Account<'info, token::Mint>,
    /// CHECK: We're about to create this with Anchor
    #[account(
        init_if_needed,
        payer = buyer_authority,
        associated_token::mint = mint,
        associated_token::authority = buyer_authority,
    )]
    pub buyer_token_account: Account<'info, token::TokenAccount>,
    #[account(mut)]
    pub buyer_authority: Signer<'info>,
    #[account(
        mut,
        has_one = mint,        
        close = buyer_authority,
        seeds=[b"state", pool.seed.to_le_bytes().as_ref()],
        bump = pool.bump,
    )]
    pub pool: Account<'info, Pool>,
    #[account(
        mut,
        associated_token::mint = mint,
        associated_token::authority = pool
    )]
    pub pool_token_account: Account<'info, token::TokenAccount>,
    /// CHECK: We're about to create this with Anchor
    #[account(
        mut,
        constraint = fee_wallet.data_is_empty(),
    )]
    pub fee_wallet: AccountInfo<'info>,
    pub rent: Sysvar<'info, Rent>,
    pub system_program: Program<'info, System>,
    pub token_program: Program<'info, token::Token>,
    pub associated_token_program: Program<'info, associated_token::AssociatedToken>,
}