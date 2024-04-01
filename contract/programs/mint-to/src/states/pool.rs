use anchor_lang::prelude::*;

#[account]
#[derive(Default)]
pub struct Pool {
    pub seed: u64,
    pub bump: u8,
    pub initializer: Pubkey,
    pub mint: Pubkey,
    pub price: u64,
}

impl Space for Pool {
    // First 8 Bytes are Discriminator (u64)
    const INIT_SPACE: usize = 8 + 8 + 1 + 32 + 32 + 8;
}