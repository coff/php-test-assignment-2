# Test assignment

Remarks:
1. Test cases are NOT 100% complete of what they suppose to be. They are only to the point I can prove I know how to 
write them.
2. Withdrawals are not implemented. I would implement them as a negative value Asset called "Withdrawal". Such asset
could be pushed onto AssetRegistry assets list. It would lower the overall balance with its negative amount value.
3. New "potential" Booster is created on each added action but only committed when there are enough actions within time limit.
This is due to the fact we don't know which 5 actions will make a valid booster before these actions actually happen. 
During commit I assign such Booster to Action object so to make sure they won't be assigned to another Booster later. 
Booster consisting of Actions that were already assigned to another Booster becomes a "zombie" and is deleted from
active boosters list.