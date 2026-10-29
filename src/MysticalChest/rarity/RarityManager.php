<?php

namespace MysticalChest\rarity;

use pocketmine\utils\TextFormat;
use pocketmine\item\VanillaItems;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;

class RarityManager
{
    public static function getColorByRarity(RarityIds $rarity) : string
    {
        return match ($rarity)
        {
            RarityIds::COMMON => TextFormat::DARK_GRAY,
            RarityIds::SOLID => TextFormat::BLUE,
            RarityIds::RICH => TextFormat::RED,
            RarityIds::ELITE => TextFormat::DARK_PURPLE
        };
    }

    public static function getItemsByRarity(RarityIds $rarity) : array
    {
        $boats = [
            VanillaItems::ACACIA_BOAT(),
            VanillaItems::BIRCH_BOAT(),
            VanillaItems::OAK_BOAT(),
            VanillaItems::JUNGLE_BOAT(),
            VanillaItems::DARK_OAK_BOAT(),
            VanillaItems::MANGROVE_BOAT(),
            VanillaItems::SPRUCE_BOAT()
        ];

        return match ($rarity)
        {
            RarityIds::COMMON => [
                VanillaItems::WOODEN_SWORD(),
                VanillaItems::WOODEN_PICKAXE(),
                VanillaItems::WOODEN_SHOVEL(),
                VanillaItems::WOODEN_AXE(),
                VanillaItems::WOODEN_HOE(),
                VanillaItems::STONE_SWORD(),
                VanillaItems::STONE_PICKAXE(),
                VanillaItems::STONE_SHOVEL(),
                VanillaItems::STONE_AXE(),
                VanillaItems::STONE_HOE(),
                VanillaItems::IRON_PICKAXE(),
                VanillaItems::IRON_SHOVEL(),
                VanillaItems::IRON_AXE(),
                VanillaItems::IRON_HOE(),
                VanillaItems::GOLDEN_PICKAXE(),
                VanillaItems::GOLDEN_SHOVEL(),
                VanillaItems::GOLDEN_AXE(),
                VanillaItems::GOLDEN_HOE(),
                VanillaItems::STICK(),
                VanillaItems::BOW(),
                VanillaItems::ARROW(),
                $boats[array_rand($boats)],
                VanillaBlocks::BED()->asItem(),
                VanillaBlocks::TORCH()->asItem(),
                VanillaBlocks::FURNACE()->asItem(),
                VanillaBlocks::CRAFTING_TABLE()->asItem(),
                VanillaBlocks::STONE_BUTTON()->asItem(),
            ],
            RarityIds::SOLID => [
                VanillaBlocks::COBBLESTONE()->asItem(),
                VanillaBlocks::STONE_BRICKS()->asItem(),
                VanillaBlocks::GRANITE()->asItem(),
                VanillaBlocks::DIORITE()->asItem(),
                VanillaBlocks::ANDESITE()->asItem(),
                VanillaBlocks::SANDSTONE()->asItem(),
                VanillaBlocks::NETHER_BRICKS()->asItem(),
                VanillaBlocks::QUARTZ()->asItem(),
                VanillaBlocks::OBSIDIAN()->asItem(),
                VanillaBlocks::SMOOTH_STONE()->asItem(),
                VanillaBlocks::PUMPKIN()->asItem(),
                VanillaBlocks::GLOWSTONE()->asItem(),
                VanillaBlocks::SEA_LANTERN()->asItem(),
                VanillaBlocks::CLAY()->asItem(),
                VanillaBlocks::GLAZED_TERRACOTTA()->asItem(),
                VanillaBlocks::PURPUR()->asItem(),
                VanillaBlocks::MAGMA()->asItem(),
                VanillaBlocks::STONE_BRICK_WALL()->asItem(),
                VanillaBlocks::SOUL_SAND()->asItem(),
                VanillaBlocks::CRYING_OBSIDIAN()->asItem(),
                VanillaBlocks::BASALT()->asItem(),
                VanillaBlocks::POLISHED_BASALT()->asItem(),
                VanillaBlocks::COPPER()->asItem(),
                VanillaBlocks::POLISHED_GRANITE()->asItem(),
                VanillaBlocks::POLISHED_DIORITE()->asItem(),
                VanillaBlocks::POLISHED_ANDESITE()->asItem(),
                VanillaBlocks::BRICKS()->asItem()
            ],
            RarityIds::RICH => [
                VanillaItems::DIAMOND_SWORD(),
                VanillaItems::DIAMOND_PICKAXE(),
                VanillaItems::DIAMOND_SHOVEL(),
                VanillaItems::DIAMOND_AXE(),
                VanillaItems::DIAMOND_HOE(),
                VanillaItems::DIAMOND_CHESTPLATE(),
                VanillaItems::DIAMOND_HELMET(),
                VanillaItems::DIAMOND_LEGGINGS(),
                VanillaItems::DIAMOND_BOOTS(),
                VanillaItems::EMERALD(),
                VanillaItems::GOLDEN_APPLE(),
                VanillaItems::ENCHANTED_GOLDEN_APPLE(),
                VanillaItems::GOLDEN_CARROT(),
                VanillaItems::LAPIS_LAZULI(),
                VanillaItems::REDSTONE_DUST(),
                VanillaItems::DIAMOND(),
                VanillaItems::NETHER_QUARTZ(),
                VanillaBlocks::EMERALD()->asItem(),
                VanillaBlocks::GOLD()->asItem(),
                VanillaBlocks::DIAMOND()->asItem(),
                VanillaBlocks::REDSTONE()->asItem(),
                VanillaItems::GOLDEN_SWORD(),
                VanillaItems::GOLDEN_CHESTPLATE(),
                VanillaItems::GOLDEN_HELMET(),
                VanillaItems::GOLDEN_LEGGINGS(),
                VanillaItems::GOLDEN_BOOTS(),
                VanillaItems::BUCKET()
            ],
            RarityIds::ELITE => [
                VanillaItems::NETHERITE_SWORD(),
                VanillaItems::NETHERITE_PICKAXE(),
                VanillaItems::NETHERITE_SHOVEL(),
                VanillaItems::NETHERITE_AXE(),
                VanillaItems::NETHERITE_HOE(),
                VanillaItems::NETHERITE_CHESTPLATE(),
                VanillaItems::NETHERITE_HELMET(),
                VanillaItems::NETHERITE_LEGGINGS(),
                VanillaItems::NETHERITE_BOOTS(),
                VanillaItems::TOTEM(),
                VanillaBlocks::BEACON()->asItem(),
                VanillaItems::DRAGON_BREATH(),
                VanillaItems::HEART_OF_THE_SEA(),
                VanillaItems::NAUTILUS_SHELL(),
                VanillaBlocks::SOUL_TORCH()->asItem(),
                VanillaItems::ENCHANTED_BOOK(),
                VanillaItems::ENDER_PEARL(),
                VanillaBlocks::DRAGON_EGG()->asItem(),
                VanillaBlocks::NETHERITE()->asItem(),
                VanillaItems::NETHERITE_INGOT(),
                VanillaBlocks::WITHER_ROSE()->asItem(),
                VanillaItems::DYE(),
                VanillaItems::PRISMARINE_SHARD(),
                VanillaItems::RABBIT_STEW(),
                VanillaItems::SPRUCE_SIGN(),
                VanillaItems::RECORD_FAR(),
                VanillaItems::RAW_PORKCHOP()
            ]
        };
    }

    public static function getContentsByRarity(RarityIds $rarity, int $inventorySize) : array
    {
        $contents = [];

        do {
            $items = self::getItemsByRarity($rarity);
            $contents = array_merge($contents, $items);

        } while (count($contents) < $inventorySize);

        shuffle($contents);

        /** @var Item $item */
        foreach ($contents as $item)
        {
            $item->setCount(mt_rand(1, ceil($item->getMaxStackSize() / ($rarity->value + 2))));
        }

        return $contents;
    }
}
