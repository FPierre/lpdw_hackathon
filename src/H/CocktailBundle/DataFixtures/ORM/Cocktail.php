<?php

namespace H\CocktailBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use H\CocktailBundle\Entity\Cocktail;
use H\CocktailBundle\Entity\Ingredient;
use H\CocktailBundle\Entity\CocktailIngredient;
use H\CocktailBundle\Entity\Color;

class Cocktails implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //$iColors = '{"Calvados":"#a59e9d","Jus de citron":"#8e6e48","Grenadine":"#cbaaa4","Liqueur de\nframboise":"#c6aba1","Cointreau":"#d5c8c1","Armagnac":"#d4ac8d","Liqueur de\nprunelle":"#f1f0e9","Jus de fruits\nde la passion":"#f5e2d3","Liqueur\nd\u2019amande\ndouce":"#d4d3ce","Cura\u00e7ao bleu":"#dbe3eb","Jus d\u2019orange":"#fcdbaf","B\u00e9n\u00e9dictine":"#9d8984","Chartreuse":"#fff","Angostura":"#bbb8a8","Liqueur de\nmandarine":"#ecdcd6","Cognac":"#b6a29f","Jus de\npamplemousse":"#f9d0be","Izarra jaune":"#faf5da","Nectar de\nraisin muscat":"#bbcbc4","Sirop de\ngrenadine":"#eae1db","Cr\u00e8me de cassis":"#bfb2a5","Liqueur de\np\u00eache":"#dfcebe","Champagne":"#2d1e12","Guignolet":"#ddd6d0","Pulpe de\np\u00eache fraiche":"#8c6449","Grand Marnier":"#a09390","Liqueur de\ncerise":"#fff","Guiness":"#615d57","Noilly Prat":"#c4c8b6","Cr\u00e8me\nd\u2019abricot":"#f8eddd","Cr\u00e8me de\nframboise":"#fff","Vermouth\nblanc":"#eceae4","Jaune d\u2019\u0153uf":"#efd6b7","Miel":"#cc941e","Sucre imbib\u00e9\nd\u2019angostura et \u00e9cras\u00e9":"#fff","Zeste de citron":"#fff","Cr\u00e8me de coco":"#d8ccbd","Liqueur de\nbanane":"#efe8d6","Gin":"#b5b2b3","Zeste de\ncitron vert":"#f0eed6","Liqueur de\nfraise":"#f3eceb","Vermouth\nrouge":"#caafa2","Vermouth\nblanc sec":"#ada69e","Alcool de poire":"#626649","Zeste d\u2019orange":"#fbe0a7","Liqueur de\npoire":"#ebeade","Liqueur\nd\u2019abricot":"#f8eddd","Nectar de\ngoyave":"#f6eee7","Cr\u00e8me de\ncacao":"#dddad5","Cr\u00e8me fraiche":"#dbd9d1","Cr\u00e8me d\u2019abricot":"#f8eddd","Martini rouge":"#e0dddc","Campari":"#ede6e4","Eau gazeuse":"#79abd6","Anisette":"#f0efe8","Liqueur de\ncaf\u00e9":"#e5e2e1","Liqueur de\ncacao":"#e7e2e0","Bitter sans\nalcool":"#b49065","Nectar de poire":"#e6dfd0","Peppermint":"#3d7e22","Lait":"#bcc0bd","Picon":"#c6b5a3","Cr\u00e8me de\nmenthe":"#fff","Vodka":"#c8bab7","Tabasco":"#fff","Poivre":"#898a60","Liqueur de\nfraises des bois":"#f3eceb","Drambuie":"#6e5638","X\u00e9r\u00e8s":"#46342e","Sherry":"#fff","Cr\u00e8me de mure":"#777e7b","Schweppes":"#e0d6c0","Cr\u00e8me de\nbanane":"#fff","Cr\u00e8me de\nmandarine":"#9e7256","Tonic":"#f1ede0","Marie Brizard":"#c5b8b7","Ginger ale":"#dfbd99","Liqueur de\nfenouil":"#889f93","Vermouth sec":"#ada69e","Ognon piqu\u00e9\nsur une\nbrochette":"#82705b","Jus de\ncitron vert":"#e3e6d7","Blanc d\u2019\u0153uf":"#fff","Amaretto":"#c7b5ae","Jus de fruits\nm\u00e9lang\u00e9s":"#a0846c","Sucre de canne":"#dccbb7","Cherry-brandy":"#937a7e","Sucre en poudre":"#e7acc0","Poire Williams":"#fff","Whisky":"#c1b8ad","Rhum brun":"#d8c6ba","Kirsch":"#fff","Nectar de\nmyrtille":"#d0cfd1","Geni\u00e8vre":"#c7cab1","Izarra verte":"#9cca9e","Jus de cerise":"#b68c8e","Brochette de\ncerises":"#ba999c","Sirop d\u2019orgeat":"#f3eee3","Parfait Amour":"#fff","Sirop de vanille":"#c3a695","Nectar de\nmandarine":"#fff","Cacao":"#696c32","Th\u00e9 chaud":"#5d5045","Eau de vie\nde poire":"#dfdcc9","Liqueur de poire":"#ebeade","Nectar de\npoire":"#e6dfd0","Mandarine\nimp\u00e9riale":"#e3cabb","Sirop de\ngingembre":"#858076","Rhum blanc":"#f6f4f2","Jus d\u2019ananas":"#e2d9aa","Cr\u00e8me de\ncacao blanc":"#eae8db","Menthe blanche":"#899e67","Rhum":"#d7cab0","Sirop de\nmandarine":"#c5bda9","Rhum Bacardi":"#e2d2c0","Eau chaude":"#fff","Cocktail de\nfruits exotiques":"#d6ac5f","Jus de citron\nvert":"#e3e6d7","Caf\u00e9 chaud":"#837c76","Citron press\u00e9":"#e8e1c3","T\u00e9quila":"#c8bbb0","Sorbet coco":"#665c53","Lait bouillant":"#292c29","Clous de girofle":"#c5bcb5","Sirop de sucre":"#61615a","Jus de goyave":"#f2d3d3","Nectar de fruits\nde la passion":"#b3a598","Nectar de\np\u00eache":"#f5ebdb","Sirop de\ncannelle":"#e9e8e5","Pulpe de fraise":"#ebe3e2","Sirop de\nframboise":"#e9e1e0","Cr\u00e8me de caf\u00e9":"#a69a84","Rondelle\nd\u2019orange":"#f3e0aa","Rondelle\nde citron":"#e2d68c","Jus de pomme":"#f8d8b7","Saumur\np\u00e9tillant":"#d0cdc7","Vin de noix":"#dfdfdb","Vin blanc\np\u00e9tillant":"#555a4b","Vin rouge\nchaud":"#85715b","Porto":"#565161","Vin blanc sec":"#ebede2","Fruits de\nsaison":"#9f754c","Vin rouge":"#e8e2e3","Zestes de\ncitron et\nd\u2019orange":"#bfb194","Bouquet\nde menthe":"#c8d8b8","Sirop d\u2019ananas":"#edeae4","Liqueur de caf\u00e9":"#e5e2e1","Jus de tomate":"#e5b1ae","Sauce anglaise":"#9a7765","Sel de c\u00e9leri\n\/poivre":"#b79d9b","Fernet Branca":"#aea483","Jus de papaye":"#fff","Bourbon":"#fff","Whisky\ncanadien":"#958781","Cr\u00e8me de cacao":"#dddad5","Scotch whisky":"#c0892e","Southern\nComfort":"#cec0b4","Jus de mangue":"#a5863e","\u0153uf entier":"#e4c3b9","Coca-Cola":"#fb1414","Jus de cassis":"#c9d9c3","Jus de groseille":"#d3ceca","Nectar de\ncerise":"#e6dadd","Jus de\nraisin blanc":"#9e785c","Jus de\nmandarine":"#f3d5ab","Sirop de\nmenthe verte":"#c9d0c7","Caf\u00e9":"#cec9c6","Chantilly":"#313539","Gel\u00e9e de\ngroseille":"#946d73","Sirop de mure":"#fff","Th\u00e9":"#fff","Th\u00e9 glac\u00e9":"#dcc8b2","Sucre":"#4a5052","Framboises":"#822f16","Fraises":"#fff","Th\u00e9 froid":"#e3a96b","Jus de poire":"#f1e7d6","Jus de banane":"#b1765f","Cidre doux":"#c2c0ac","Jus de quetsche":"#d8cfd4","Cidre brut":"#bebda9","Sirop de\nbanane":"#fff","Sirop de citron":"#867741","Sirop de caf\u00e9":"#fff","Glace \u00e0 la\nvanille":"#ddd2bc","Sirop de\nmenthe":"#e1e9dc","Sirop de\nr\u00e9glisse":"#c5bda9","Sorbet au\ncitron vert":"#dadaa1","Glace \u00e0 la\nfraise":"#bd8382","Ricql\u00e8s":"#aab2c7","Sorbet \u00e0\nl\u2019ananas":"#cccdb6","Ananas\np\u00e9tillant":"#fff","Sorbet au\ncassis":"#bf717a","Lait d\u2019amande":"#b4b5b5","Pulpe d\u2019abricot":"#684f45","Jus de p\u00eache":"#fbf1e4","Nectar d\u2019abricot":"#f6dec1","Sirop de cassis":"#e9e5e4","Sirop de fraise":"#e3dbd8","Jus de raisin":"#c5afb7","Jus de\nraisin rouge":"#85564b","Jus de melon":"#f8dfbc","Jus de\nframboise":"#fff","Jus de pomme\np\u00e9tillant":"#f9f0e0","Sirop de\nmyrtille":"#fff","Limonade":"#9a9068","Sirop de\nvanille":"#c3a695","Jus de\nmangue":"#a5863e","Jus de\nmyrtille":"#fff","Nectar de\ncitron vert":"#e9ebda","Nectar de\nmangue":"#e3dbc3","Sirop de\ncerise":"#ece5e4","Jus de\npruneaux":"#e4dfd8","Nectar de\nbanane":"#e6cb9a","Pulpe de kiwi":"#e9e7e4","Jus de\nraisin muscat":"#e3dbc2","Sirop d\u2019orange":"#fff","Mandarines\nbroy\u00e9es au mixer":"#c4b7a8","Cacao en poudre":"#ba6676","Sirop de\npomme":"#dccab9","Sirop de fruits\nde la passion":"#c5bda9","Coulis de\nframboise":"#928785","Sirop de\nmenthe blanc":"#e3ece0","Sirop de\nchocolat":"#e1e0df","Tranches d\u2019oran-\nge piqu\u00e9es de\nclous de girofle":"#84592d","Cerises noires":"#fff","Quartiers\nd\u2019ananas":"#e9c38f","Cannelle":"#cfb8a8","Eau de fleur\nd\u2019oranger":"#f5f3ee","Jus de p\u00eache\nde vigne":"#efe4e4","Jus de raisin\nrouge":"#85564b","Jus de raisin\nblanc":"#9e785c","Radis pass\u00e9s\nau mixer":"#5e655d","Tomates pass\u00e9es\nau mixer":"#58423b","Sel de c\u00e9leri":"#7a7065","Pinc\u00e9e de\nfeuilles de men-\nthe \u00e9minc\u00e9es":"#6b585c","Jus de\nconcombre":"#b9b780","Jus de carotte":"#fff","Pointe de\npiment":"#868b87","Jeune carotte":"#b69c87","Feuilles\nd\u2019\u00e9pinards":"#75884d","Brins de persil":"#5f6e54","Brins de cresson":"#89755e","C\u00f4te de c\u00e9leri":"#d5d386","Betterave\nrouge cuite":"#735b42","Feuilles\nde laitue":"#a8b17f","Tomate":"#e3a68e","Jus de fenouil":"#c4d0b0","Carottes":"#90641d","Pomme":"#fff","Orange":"#f9cd8e","Feuilles\nde menthe":"#5e8c19","Goutte de\ntabasco":"#fff","Tours de moulin\n\u00e0 poivre":"#6b5854","Sirop de melon":"#fff","Vanille":"#d5c6c2","Blancs d\u2019\u0153uf":"#fff","Banane broy\u00e9e\nau mixer":"#fff","Fraises\n\u00e9cras\u00e9es":"#ac7f77","Gla\u00e7ons\nde lait":"#fff","Extrait de\nvanille":"#ad8c76","Sirop de menthe":"#e1e9dc","Sirop de menthe\nblanche":"#fff","Sauce chocolat":"#bca7a9","Lait chaud":"#ece3d3","Eau de rose":"#fff","Sirop d\u2019anis":"#f1ede4","Sirop de vanil-\nle coco":"#c5bda9","Sirop d\u2019\u00e9rable":"#f7dfc0","Sorbet\nde mure":"#9d6d6d"}';

        // Nouvelles couleurs avec saturation à 50
        $iColors = '{"Calvados":"#cf7d71","Jus de citron":"#a06f35","Grenadine":"#db9e93","Liqueur de\nframboise":"#d8a08c","Cointreau":"#e5c4b2","Armagnac":"#d7aa88","Liqueur de\nprunelle":"#f6f3e4","Jus de fruits\nde la passion":"#f0e1d4","Liqueur\nd\u2019amande\ndouce":"#e8e0ba","Cura\u00e7ao bleu":"#d4e2f0","Jus d\u2019orange":"#ead9c1","B\u00e9n\u00e9dictine":"#c8705a","Chartreuse":"#bf473f","Angostura":"#d8cc8c","Liqueur de\nmandarine":"#efd9d1","Cognac":"#d48b80","Jus de\npamplemousse":"#edd4c9","Izarra jaune":"#f4f1e0","Nectar de\nraisin muscat":"#a3e0c5","Sirop de\ngrenadine":"#f0e0d4","Cr\u00e8me de cassis":"#d8b28c","Liqueur de\np\u00eache":"#e6cdb6","Champagne":"#2d1c0f","Guignolet":"#ead4c1","Pulpe de\np\u00eache fraiche":"#a06035","Grand Marnier":"#cc7965","Liqueur de\ncerise":"#bf473f","Guiness":"#89642d","Noilly Prat":"#d0df9f","Cr\u00e8me\nd\u2019abricot":"#f4ece0","Cr\u00e8me de\nframboise":"#bf473f","Vermouth\nblanc":"#f3eddc","Jaune d\u2019\u0153uf":"#e9d5bd","Miel":"#af8a3a","Sucre imbib\u00e9\nd\u2019angostura et \u00e9cras\u00e9":"#bf473f","Zeste de citron":"#bf473f","Cr\u00e8me de coco":"#e4ccae","Liqueur de\nbanane":"#f0e9d4","Gin":"#d88ca5","Zeste de\ncitron vert":"#f0eed4","Liqueur de\nfraise":"#f7e9e8","Vermouth\nrouge":"#daa890","Vermouth\nblanc sec":"#d2a879","Alcool de poire":"#76822b","Zeste d\u2019orange":"#e8d9ba","Liqueur de\npoire":"#f2f0d8","Liqueur\nd\u2019abricot":"#f4ece0","Nectar de\ngoyave":"#f7efe8","Cr\u00e8me de\ncacao":"#ebddc5","Cr\u00e8me fraiche":"#eae2c1","Cr\u00e8me d\u2019abricot":"#f4ece0","Martini rouge":"#eed5cd","Campari":"#f3e1dc","Eau gazeuse":"#7cabd3","Anisette":"#f6f3e4","Liqueur de\ncaf\u00e9":"#f0dbd4","Liqueur de\ncacao":"#f0dcd4","Bitter sans\nalcool":"#c59152","Nectar de poire":"#ede1c9","Peppermint":"#3e7627","Lait":"#9fdfaf","Picon":"#dab690","Cr\u00e8me de\nmenthe":"#bf473f","Vodka":"#dfaa9f","Tabasco":"#bf473f","Poivre":"#adaf3a","Liqueur de\nfraises des bois":"#f7e9e8","Drambuie":"#7e582a","X\u00e9r\u00e8s":"#572b1d","Sherry":"#bf473f","Cr\u00e8me de mure":"#3db783","Schweppes":"#e8d9ba","Cr\u00e8me de\nbanane":"#bf473f","Cr\u00e8me de\nmandarine":"#b76c3d","Tonic":"#f3eedc","Marie Brizard":"#dfa39f","Ginger ale":"#ddbd9b","Liqueur de\nfenouil":"#5ec991","Vermouth sec":"#d2a879","Ognon piqu\u00e9\nsur une\nbrochette":"#a47136","Jus de\ncitron vert":"#e7eecd","Blanc d\u2019\u0153uf":"#bf473f","Amaretto":"#dcab97","Jus de fruits\nm\u00e9lang\u00e9s":"#c3824b","Sucre de canne":"#e4cbae","Cherry-brandy":"#c34b5e","Sucre en poudre":"#e4aec0","Poire Williams":"#bf473f","Whisky":"#dbbb93","Rhum brun":"#e4c4ae","Kirsch":"#bf473f","Nectar de\nmyrtille":"#d1bae8","Geni\u00e8vre":"#d5dd9b","Izarra verte":"#8cd88f","Jus de cerise":"#cf7175","Brochette de\ncerises":"#d37c84","Sirop d\u2019orgeat":"#f4eee0","Parfait Amour":"#bf473f","Sirop de vanille":"#d49f80","Nectar de\nmandarine":"#bf473f","Cacao":"#727627","Th\u00e9 chaud":"#7a4e28","Eau de vie\nde poire":"#e9e3bd","Liqueur de poire":"#f2f0d8","Nectar de\npoire":"#ede1c9","Mandarine\nimp\u00e9riale":"#e6c8b6","Sirop de\ngingembre":"#bb913e","Rhum blanc":"#f9f4ef","Jus d\u2019ananas":"#e2d9aa","Cr\u00e8me de\ncacao blanc":"#f0edd4","Menthe blanche":"#90c043","Rhum":"#e1cea7","Sirop de\nmandarine":"#dbc693","Rhum Bacardi":"#e8d2ba","Eau chaude":"#bf473f","Cocktail de\nfruits exotiques":"#cdaa69","Jus de citron\nvert":"#e7eecd","Caf\u00e9 chaud":"#bb783e","Citron press\u00e9":"#eae2c1","T\u00e9quila":"#ddb99b","Sorbet coco":"#89592d","Lait bouillant":"#154115","Clous de girofle":"#ddb89b","Sirop de sucre":"#8d8d2f","Jus de goyave":"#f0d4d4","Nectar de fruits\nde la passion":"#d2a479","Nectar de\np\u00eache":"#f3eadc","Sirop de\ncannelle":"#f3eddc","Pulpe de fraise":"#f2dbd8","Sirop de\nframboise":"#f2dbd8","Cr\u00e8me de caf\u00e9":"#c9a35e","Rondelle\nd\u2019orange":"#e6dab6","Rondelle\nde citron":"#dbd193","Jus de pomme":"#ebd9c5","Saumur\np\u00e9tillant":"#e5d4b2","Vin de noix":"#eeeecd","Vin blanc\np\u00e9tillant":"#5f7a28","Vin rouge\nchaud":"#a87238","Porto":"#482c85","Vin blanc sec":"#eff3dc","Fruits de\nsaison":"#af743a","Vin rouge":"#f2d8dd","Zestes de\ncitron et\nd\u2019orange":"#d3b77c","Bouquet\nde menthe":"#c6e2aa","Sirop d\u2019ananas":"#f3ebdc","Liqueur de caf\u00e9":"#f0dbd4","Jus de tomate":"#e4b1ae","Sauce anglaise":"#bf6b3f","Sel de c\u00e9leri\n\/poivre":"#d3837c","Fernet Branca":"#ccb465","Jus de papaye":"#bf473f","Bourbon":"#bf473f","Whisky\ncanadien":"#c57552","Cr\u00e8me de cacao":"#ebddc5","Scotch whisky":"#b3863b","Southern\nComfort":"#e0bfa3","Jus de mangue":"#ac8939","\u0153uf entier":"#e6c1b6","Coca-Cola":"#c34b4b","Jus de cassis":"#c3e6b6","Jus de groseille":"#e6cbb6","Nectar de\ncerise":"#efd1d8","Jus de\nraisin blanc":"#bb733e","Jus de\nmandarine":"#e6d2b6","Sirop de\nmenthe verte":"#bde5b2","Caf\u00e9":"#e4c2ae","Chantilly":"#1a3550","Gel\u00e9e de\ngroseille":"#bf3f53","Sirop de mure":"#bf473f","Th\u00e9":"#bf473f","Th\u00e9 glac\u00e9":"#e2c8aa","Sucre":"#276276","Framboises":"#723726","Fraises":"#bf473f","Th\u00e9 froid":"#d2a779","Jus de poire":"#f0e6d4","Jus de banane":"#c36c4b","Cidre doux":"#dbd493","Jus de quetsche":"#e9bdd6","Cidre brut":"#d8d58c","Sirop de\nbanane":"#bf473f","Sirop de citron":"#957f31","Sirop de caf\u00e9":"#bf473f","Glace \u00e0 la\nvanille":"#e5d4b2","Sirop de\nmenthe":"#dff0d4","Sirop de\nr\u00e9glisse":"#dbc693","Sorbet au\ncitron vert":"#dddd9b","Glace \u00e0 la\nfraise":"#cf7371","Ricql\u00e8s":"#93a7db","Sorbet \u00e0\nl\u2019ananas":"#dde0a3","Ananas\np\u00e9tillant":"#bf473f","Sorbet au\ncassis":"#cc6571","Lait d\u2019amande":"#90dada","Pulpe d\u2019abricot":"#82442b","Jus de p\u00eache":"#f7f0e8","Nectar d\u2019abricot":"#eddcc9","Sirop de cassis":"#f2ddd8","Sirop de fraise":"#eed6cd","Jus de raisin":"#dc97b0","Jus de\nraisin rouge":"#9c4834","Jus de melon":"#ebdbc5","Jus de\nframboise":"#bf473f","Jus de pomme\np\u00e9tillant":"#f6efe4","Sirop de\nmyrtille":"#bf473f","Limonade":"#c0a743","Sirop de\nvanille":"#d49f80","Jus de\nmangue":"#ac8939","Jus de\nmyrtille":"#bf473f","Nectar de\ncitron vert":"#edf0d4","Nectar de\nmangue":"#e9debd","Sirop de\ncerise":"#f3dfdc","Jus de\npruneaux":"#eee0cd","Nectar de\nbanane":"#dfc89f","Pulpe de kiwi":"#f2e8d8","Jus de\nraisin muscat":"#e9debd","Sirop d\u2019orange":"#bf473f","Mandarines\nbroy\u00e9es au mixer":"#dab790","Cacao en poudre":"#c6566c","Sirop de\npomme":"#e4c8ae","Sirop de fruits\nde la passion":"#dbc693","Coulis de\nframboise":"#c56452","Sirop de\nmenthe blanc":"#dff2d8","Sirop de\nchocolat":"#efe0d1","Tranches d\u2019oran-\nge piqu\u00e9es de\nclous de girofle":"#85592c","Cerises noires":"#bf473f","Quartiers\nd\u2019ananas":"#ddc19b","Cannelle":"#ddb69b","Eau de fleur\nd\u2019oranger":"#f8f4eb","Jus de p\u00eache\nde vigne":"#f4e0e0","Jus de raisin\nrouge":"#9c4834","Jus de raisin\nblanc":"#bb733e","Radis pass\u00e9s\nau mixer":"#3c9130","Tomates pass\u00e9es\nau mixer":"#6e3624","Sel de c\u00e9leri":"#a87238","Pinc\u00e9e de\nfeuilles de men-\nthe \u00e9minc\u00e9es":"#913044","Jus de\nconcombre":"#cdc969","Jus de carotte":"#bf473f","Pointe de\npiment":"#4fc466","Jeune carotte":"#ce986d","Feuilles\nd\u2019\u00e9pinards":"#7ea035","Brins de persil":"#599130","Brins de cresson":"#ac7639","C\u00f4te de c\u00e9leri":"#d6d484","Betterave\nrouge cuite":"#855a2c","Feuilles\nde laitue":"#b9cc65","Tomate":"#dba893","Jus de fenouil":"#c7df9f","Carottes":"#82602b","Pomme":"#bf473f","Orange":"#e1c9a7","Feuilles\nde menthe":"#597a28","Goutte de\ntabasco":"#bf473f","Tours de moulin\n\u00e0 poivre":"#8d3f2f","Sirop de melon":"#bf473f","Vanille":"#e5bdb2","Blancs d\u2019\u0153uf":"#bf473f","Banane broy\u00e9e\nau mixer":"#bf473f","Fraises\n\u00e9cras\u00e9es":"#c86b5a","Gla\u00e7ons\nde lait":"#bf473f","Extrait de\nvanille":"#c8865a","Sirop de menthe":"#dff0d4","Sirop de menthe\nblanche":"#bf473f","Sauce chocolat":"#d88c93","Lait chaud":"#efe4d1","Eau de rose":"#bf473f","Sirop d\u2019anis":"#f4eee0","Sirop de vanil-\nle coco":"#dbc693","Sirop d\u2019\u00e9rable":"#edddc9","Sorbet\nde mure":"#c14747"}';
        $iColors = json_decode($iColors);

        $cocktails = $this->csvToArray('/Users/LEI/Projects/LPDW/PHP/Symfony/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        //$cocktails = $this->csvToArray('/var/www/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');
        //$cocktails = $this->csvToArray('/Users/aureliendumont/SiteWeb/hackathon/src/H/CocktailBundle/DataFixtures/ORM/cocktails.csv');

        // Cocktail
        foreach ($cocktails as $name => $c) {

            $cocktail = new Cocktail();
            $cocktail->setName($name);
            $cocktail->setcomment('Lorem');

            $manager->persist($cocktail);
        }

        $manager->flush();

        // Ingredient
        foreach ($cocktails as $name => $c) {

            $em = $manager->getRepository('HCocktailBundle:Cocktail');
            $cocktail = $em->findOneByName($name);

            foreach ($c as $ingredientName => $proportion) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($ingredientName);

                if (!$ingredient) {

                    $ingredient = new Ingredient();
                    $ingredient->setName($ingredientName);

                    $color = $iColors->$ingredientName;
                    $ingredient->setColor($color);

                    //echo $color . ' ' . $ingredientName . ' - ';

                    $manager->persist($ingredient);

                    $manager->flush();
                }
            }
        }

        // CocktailIngredient
        foreach ($cocktails as $name => $c) {
            $em = $manager->getRepository('HCocktailBundle:Cocktail');
            $cocktail = $em->findOneByName($name);

            foreach ($c as $ingredientName => $proportion) {

                $em = $manager->getRepository('HCocktailBundle:Ingredient');
                $ingredient = $em->findOneByName($ingredientName);

                $cocktailIngredient = new CocktailIngredient();
                $cocktailIngredient->setCocktail($cocktail);
                $cocktailIngredient->setIngredient($ingredient);

                if (!is_numeric($proportion) || $proportion == 0) {
                    $proportion = 1;
                }
                $cocktailIngredient->setProportion($proportion);

                $manager->persist($cocktailIngredient);
            }
        }

        $manager->flush();
    }

    public function csvToArray($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $allDatas = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                //var_dump($row);
                if(!$header)
                    $header = $row;
                else
                    $allDatas[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        $result = array();
        $name = '';
        foreach ($allDatas as $key => $oneData) {

            if($oneData['nom'] != ''){
                $name = ucfirst($oneData['nom']);
                $result[$name] = array();
                $result[$name][ucfirst($oneData['ingrédients'])] = substr($oneData['proportions'], 0, 1);
                //$result[$name]['proportion'][] = $oneData['proportions'];
            }else{
                $result[$name][ucfirst($oneData['ingrédients'])] = substr($oneData['proportions'], 0, 1);
            }

        }

        return $result;
    }

    public function getOrder()
    {
        return 2;
    }
}