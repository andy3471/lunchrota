export type HomePageData = {
lunchSlots: Array<LunchSlotData>;
initialSlot: number | null;
available: boolean;
userLunches: Array<UserLunchData>;
roles: Array<RoleData>;
selectedDate: string;
};
export type LunchSlotData = {
id: number;
time: string;
available_today: number;
};
export type RoleData = {
name: string;
role: string;
available: number;
};
export type UserLunchData = {
id: number;
name: string;
time: string;
};
