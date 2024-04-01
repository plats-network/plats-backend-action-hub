use anchor_lang::prelude::*;

mod instructions;
mod states;
mod error;
use self::instructions::*;

declare_id!("D5GK8Kye78gjuDMMjRnkWH5a6KfNEXzex5mekXL3HLR2");


#[program]
pub mod nft {
    use super::*;

    pub fn mint(
        ctx: Context<MintNft>, 
        metadata_title: String, 
        metadata_symbol: String, 
        metadata_uri: String,
    ) -> Result<()> {
        MintNft::mint(
            ctx,
            metadata_title,
            metadata_symbol,
            metadata_uri,
        )
    }

    pub fn deposit(
        ctx: Context<DepositNft>, 
        seed: u64,
        price: u64
    ) -> Result<()> {
        DepositNft::deposit(
            ctx,
            seed,
            price,
        )
    }

    pub fn claim(
        ctx: Context<ClaimNft>
    ) -> Result<()> {
        ClaimNft::claim(ctx)
    }
}