use {
    anchor_lang::{
        prelude::*,
    },
    anchor_spl::{
        associated_token,
        token,
    },
};

use crate::states::{Pool};

impl DepositNft<'_> {
    pub fn deposit(
        ctx: Context<DepositNft>, 
        seed: u64,
        price: u64,
    ) -> Result<()> {

        let pool = &mut ctx.accounts.pool;
        pool.seed = seed;
        pool.bump = ctx.bumps.pool;
        pool.price = price;
        pool.mint = ctx.accounts.mint.key();
        pool.initializer = ctx.accounts.mint_authority.key();
        msg!("Pool initialized successfully.");
    
        msg!("Transferring NFT...");
        msg!("Owner Token Address: {}", &ctx.accounts.token_account.key());    
        msg!("Pool Token Address: {}", &ctx.accounts.pool_token_account.key());    
        token::transfer(
            CpiContext::new(
                ctx.accounts.token_program.to_account_info(),
                token::Transfer {
                    from: ctx.accounts.token_account.to_account_info(),
                    to: ctx.accounts.pool_token_account.to_account_info(),
                    authority: ctx.accounts.mint_authority.to_account_info(),
                }
            ),
            1
        )?;
        msg!("Close token account...");
        msg!("Token account Address: {}", &ctx.accounts.token_account.key()); 
        msg!("Closing...");
        token::close_account(
            CpiContext::new(
                ctx.accounts.token_program.to_account_info(),
                token::CloseAccount {
                    account: ctx.accounts.token_account.to_account_info(),
                    destination: ctx.accounts.mint_authority.to_account_info(),
                    authority: ctx.accounts.mint_authority.to_account_info(),
                }
            )
        )?;
        msg!("Token address closed successfully.");

        // let pool = &mut ctx.accounts.pool;
        // pool.price = Self::get_price(metadata_symbol);
        // pool.mint = ctx.accounts.mint.key();
        // pool.initializer = ctx.accounts.mint_authority.key();
        // msg!("Pool initialized successfully.");

        msg!("NFT transferred successfully.");
        Ok(())
        
    }

    // fn init_pool(
    //     ctx: &Context<MintNft>, 
    //     seed: u64,
    //     metadata_symbol: &String,
    // ) -> Result<()> {
    //     let pool = mut ctx.accounts.pool;
    //     pool.seed = seed;
    //     pool.price = Self::get_price(metadata_symbol);
    //     pool.mint = ctx.accounts.mint.key();
    //     pool.initializer = ctx.accounts.mint_authority.key();
    //     msg!("Pool initialized successfully.");
    //     Ok(())
    // }

    // pub fn get_price(symbol: &String) -> u64 {
    //     let mut word = String::new();
    //     word.push_str("TICKET");
    //     if symbol == &word {
    //         123000000
    //     } else {
    //         0
    //     }
    // }
}

#[derive(Accounts)]
#[instruction(seed: u64)]
pub struct DepositNft<'info> {
    #[account(mut)]
    pub mint: Account<'info, token::Mint>,
    /// CHECK: We're about to create this with Anchor
    #[account(mut)]
    pub token_account: Account<'info, token::TokenAccount>,
    #[account(mut)]
    pub mint_authority: Signer<'info>,
    #[account(
        init_if_needed,
        payer = mint_authority,
        space = Pool::INIT_SPACE,
        seeds = [b"state".as_ref(), &seed.to_le_bytes()],
        bump
    )]
    pub pool: Account<'info, Pool>,
    #[account(
        init_if_needed,
        payer = mint_authority,
        associated_token::mint = mint,
        associated_token::authority = pool
    )]
    pub pool_token_account: Account<'info, token::TokenAccount>,
    pub rent: Sysvar<'info, Rent>,
    pub system_program: Program<'info, System>,
    pub token_program: Program<'info, token::Token>,
    pub associated_token_program: Program<'info, associated_token::AssociatedToken>,
}
