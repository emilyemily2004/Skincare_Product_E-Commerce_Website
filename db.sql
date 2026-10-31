-- Creating the database
CREATE DATABASE aurevia_db CHARACTER SET utf8 COLLATE utf8_general_ci;

USE aurevia_db;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id VARCHAR(50) PRIMARY KEY,
  brand TEXT,
  productKey TEXT,
  name TEXT,
  category TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  briefDescription TEXT,
  description TEXT,
  ingredients TEXT,
  skinType TEXT,
  remark TEXT,
  image TEXT
);

CREATE TABLE cartItem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    productID VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (userID) REFERENCES user(id),
    FOREIGN KEY (productID) REFERENCES products(id),
    UNIQUE KEY unique_cart (userID, productID)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    totalPrice DECIMAL(10,2) NOT NULL,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    address TEXT,
    FOREIGN KEY (userID) REFERENCES user(id)
);

CREATE TABLE orderItem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT NOT NULL,
    productID VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (orderID) REFERENCES orders(id),
    FOREIGN KEY (productID) REFERENCES products(id)
);


INSERT INTO `products` (`id`,`brand`,`productKey`,`name`,`category`,`price`,`briefDescription`,`description`,`ingredients`,`skinType`,`remark`,`image`) VALUES 
("cerave01","CeraVe","cerave","Foaming Facial Cleanser","cleanser",70.00,"Foaming gel cleanser for normal-to-oily skin","The CeraVe Foaming Cleanser is ideal for removing excess oil, dirt and makeup. This oil-free cleanser is gentle and does not disrupt the skin natural protective barrier. It contains ingredients that help maintain moisture balance and improve the overall skin health. The CeraVe cleanser for oily skin combines ceramides, hyaluronic acid and niacinamide to help restore the skin moisture barrier, attract hydration and calm the skin. This CeraVe wash for oily skin is developed by dermatologists to deeply cleanse, remove excess oil and refresh the skin without over-stripping it or leaving it feeling tight and dry. Featuring three essential ceramides, hyaluronic acid and niacinamide, this gel-based foaming cleanser is an effective yet non-irritating way to cleanse and care for normal to oily skin.",
"Aqua/water, Cocamidopropyl Hydroxysultaine, Glycerin, Sodium Lauroyl Sarcosinate, Propanediol, Peg-150 Pentaerythrityl Tetrastearate, Niacinamide, Peg-6 Caprylic/capric Glycerides, Ceramide Np, Ceramide Ap, Ceramide Eop, Carbomer, Sodium Methyl Cocoyl Taurate, Sodium Benzoate, Sodium Chloride, Sodium Lauroyl Lactylate, Sodium Hyaluronate, Cholesterol, Phenoxyethanol, Disodium Edta, Citric Acid, Tetrasodium Edta, Phytosphingosine, Xanthan Gum, Ethylhexylglycerin",
'["acne","sensitive"]',"bestSeller","../image/cleanser/ceraveFoamCleanser.png"),

("cerave02","CeraVe","cerave","Hydrating Cleanser","cleanser",60.00,"Hydrating cleanser for normal-to-dry skin","A cleanser can remove dirt, makeup and other debris from the skin. But a hydrating cleanser like the CeraVe Hydrating Cleanser can do all that without disrupting the skin’s natural protective barrier or stripping the skin of its natural moisture. Created with dermatologists, the CeraVe Hydrating Cleanser is a gentle wash powered with ingredients like ceramides and hyaluronic acid that work to restore the skin’s natural barrier and lock in moisture. The CeraVe hydrating wash is designed to cleanse and refresh the skin without over-stripping it or leaving it feeling tight and dry. Featuring three essential ceramides to restore the skin's barrier, hyaluronic acid to hydrate the skin, and MVE Delivery Technology to supply the skin with a steady stream of nourishment, this non-comedogenic hydrating cleanser is an effective yet non-irritating way to start any skincare regimen. Best for normal to dry skin.", 
"Aqua / Water , Glycerin, Cetearyl Alcohol, Peg-40 Stearate, Stearyl Alcohol, Potassium Phosphate, Ceramide Np, Ceramide Ap, Ceramide Eop, Carbomer, Glyceryl Stearate, Behentrimonium Methosulfate, Sodium Lauroyl Lactylate, Sodium Hyaluronate, Cholesterol, Phenoxyethanol, Disodium Edta, Dipotassium Phosphate, Tocopherol, Phytosphingosine, Xanthan Gum, Cetyl Alcohol, Polysorbate 20, Ethylhexylglycerin", 
'["dehydrated","sensitive"]',NULL,"../image/cleanser/ceraveHydratingCleanser.png"),

("cerave03", "CeraVe", "cerave", "AM Facial Moisturising Lotion", "moisturizer", 65.50, "Non-comedogenic moisturiser with SPF 30", 
"Cerave Facial Moisturising Lotion Am SPF 30 is the ultimate morning skincare multitasker. Featuring three essential ceramides, hydrating hyaluronic acid and soothing niacinamide, this face cream with sunscreen contains MVE Technology to maintain hydration levels in the skin. Offering Broad Spectrum sunscreen, the Cerave Am Facial Moisturising Lotion formula spreads easily and evenly while leaving a residue-free clear finish. The Cerave face cream with SPF is a non-comedogenic formula that won’t clog your pores. Best suited for normal to dry skin.",
"Aqua/water, Glycerin, Isopropyl Palmitate, Ethylhexyl Salicylate, Niacinamide, Pentylene Glycol, Bis-ethylhexyloxyphenol Methoxyphenyl Triazine, Butyl Methoxydibenzoylmethane, Zea Mays Starch/corn Starch, Ethylhexyl Triazone, Potassium Cetyl Phosphate, Diisopropyl Sebacate, Oryza Sativa Cera/rice Bran Wax, Stearic Acid, Ceramide Np, Ceramide Ap, Ceramide Eop, Carbomer, Glyceryl Stearate, Cetearyl Alcohol, Triethanolamine, Behentrimonium Methosulfate, Triethyl Citrate, Sodium Hyaluronate, Sodium Lauroyl Lactylate, Myristic Acid, Cholesterol, Palmitic Acid, Tocopherol, Caprylyl Glycol, Trisodium Ethylenediamine Disuccinate, Xanthan Gum, Phytosphingosine, Acrylates/c10-30 Alkyl Acrylate Crosspolymer, Benzoic Acid, Peg-100 Stearate", 
'["sensitive","dehydrated"]', NULL, "../image/moisturizer/ceraveAMMoisturizer.png"),

("cerave04", "CeraVe", "cerave", "PM Facial Moisturising Lotion", "moisturizer", 65.50, "Night cream with niacinamide", 
"Your skin needs moisture around the clock and investing in a night face moisturiser can help you achieve the task. The Cerave Facial Moisturising Lotion PM can become a boon for your skin’s health as it contains niacinamide, which helps calm the skin while you sleep. This facial moisturising lotion also packs the goodness of hyaluronic acid and ceramides that can help your skin hold on to moisture and restore the skin's barrier at night. Additionally, this CeraVe PM Moisturiser is a non-comedogenic night-time moisturiser that does not clog your pores or cause acne flare-ups. Created with dermatologists, Cerave Facial Moisturising Lotion for PM routine combines three essential ceramides, hyaluronic acid and niacinamide in an oil-free, non-comedogenic formula that helps hydrate and calm the skin while restoring its natural barrier. This rich, yet lightweight night face moisturiser uses our patented MVE Delivery Technology to deliver moisture to your skin throughout the night. Suitable for normal to dry skin.",
"Aqua / Water, Glycerin, Caprylic/capric Triglyceride, Niacinamide, Cetearyl Alcohol, Potassium Phosphate, Ceramide Np, Ceramide Ap, Ceramide Eop, Carbomer, Dimethicone, Ceteareth-20, Behentrimonium Methosulfate, Sodium Lauroyl Lactylate, Sodium Hyaluronate, Cholesterol, Phenoxyethanol, Disodium Edta, Dipotassium Phosphate, Caprylyl Glycol, Phytosphingosine, Xanthan Gum, Polyglyceryl-3 Diisostearate, Ethylhexylglycerin", 
'["sensitive","dehydrated"]', "bestSeller", "../image/moisturizer/ceravePMMoisturizer.png"),

("avene01", "Eau Thermale Avène", "avene", "Les Essentiels", "cleanser", 70.00, "Cleanser, makeup remover, soothing", 
"Soft and fresh, this soap-free, high tolerance foaming gel is very rich in Avène Thermal Water. Soap-free, it respects the most sensitive skin. A gentle cleanser and make-up remover for naturally hypersensitive skin or skin that has become sensitised by various environmental aggressions.",
"Avene Thermal Spring Water (Avene Aqua). Water (Aqua). Sodium Laureth Sulfate. Disodium Laureth Sulfosuccinate. Disodium Cocoamphodiacetate. Sodium Chloride. Lauryl Betaine. Glycerin. Peg-7 Glyceryl Cocoate. Citric Acid. Cocamide Mipa. Disodium Edta. Phenoxyethanol. Sodium Benzoate", 
'["dehydrated"]', NULL, "../image/cleanser/aveneLesEssentiels.png"),

("avene02", "Eau Thermale Avène", "avene", "Cleanance Cleansing Gel", "cleanser", 65.50, "Purifying, cleansing, mattifying", 
"A purifying foaming gel cleanser for oily and/or blemish-prone skin. Its formula that respects sensitive skin combines a unique combination of active ingredients with triple benefits: gentle cleansing thanks to a gentle cleansing base, a mattifying effect guaranteed by Comedoclastin™, a plant-based patented active ingredient derived from milk thistle seeds that reduces excess sebum, and comfort provided by softening, soothing and anti-irritating Avène Thermal Spring Water. Skin is clean, fresh, purified and less shiny. Cleanance Cleansing Gel is suitable for contact lens wearers. It is soap-free and offers very good skin tolerance.",
"Avene Thermal Spring Water (Avene Aqua). Water (Aqua). Zinc Coceth Sulfate. Lauryl Betaine. Decyl Glucoside. Ceteareth-60 Myristyl Glycol. Peg-7 Glyceryl Cocoate. Polysorbate 20. Citric Acid. Fragrance (Parfum). Green 5 (Ci 61570). Isopropyl Alcohol. Peg-40 Hydrogenated Castor Oil. Peg-6. Ppg-26-buteth-26. Silybum Marianum Fruit Extract. Sodium Benzoate. Sodium Chloride. Sodium Hydroxide. Trisodium Ethylenediamine Disuccinate. Yellow 5 (Ci 19140). Zinc Gluconate", 
'["acne","sensitive"]', NULL, "../image/cleanser/aveneCleanance.png"),

("avene03", "Eau Thermale Avène", "avene", "Thermal Spring Water Spray", "toner", 50.00, "Calms, Soothes, Restores the skin barrier", 
"The Thermal Spring Water Spray instantly softens and soothes sensitive or allergy-prone skin. Avène Thermal Spring Water, enriched with more than half a century's worth of experience, is bursting with minerals and trace elements. It ensures an optimal mineral balance and a specific microflora, providing it with its unique and exceptional composition that conditions the skin without drying it out, making it a key part of any beauty routine. The Thermal Spring Water Spray can be used by the whole family on the face and body for soothed, softened and healthy skin.",
"Avene Thermal Spring Water (Avene Aqua). Gas : Nitrogen", '["sensitive","dehydrated"]', "bestSeller", "../image/toner/aveneSpray.png"),

("avene04", "Eau Thermale Avène", "avene", "Gentle Toning Lotion", "toner", 79.90, "Soothes, Tones", 
"This toning lotion perfects makeup removal, gently protects the skin and respects the integrity of every skin type, even the most sensitive. A gentle toner rich in Avène Thermal Spring Water, soothing and anti-irritant, it gives the skin an immediate feeling of comfort. Alcohol-free.",
"Avene Thermal Spring Water (Avene Aqua). Fragrance (Parfum). Hydrogenated Starch Hydrolysate. Peg-7 Glyceryl Cocoate. Phenoxyethanol. Stearalkonium Hectorite. Trisodium Edta. Water (Aqua)", 
'["dehydrated","uneven"]', NULL, "../image/toner/aveneToner.png"),

("avene05", "Eau Thermale Avène", "avene", "High Protection Fluid SPF 50+", "suncare", 80.00, "High sun protection SPF50+ for all skin types", 
"The SPF 50+ Fluid offers ultra-broad spectrum daily sun protection. It’s ideal for normal sensitive to combination skin on the face. Its light texture allows absorption in 3 seconds* and leaves an invisible finish on the skin. The SPF 50+ Fluid leaves an imperceptible, non-shiny finish on the skin when applied and is an excellent base for everyday make-up. The formula is also water resistant.",
"Avene Thermal Spring Water (Avene Aqua). C12-15 Alkyl Benzoate. Diethylamino Hydroxybenzoyl Hexyl Benzoate. Ethylhexyl Triazone. Oryza Sativa (Rice) Starch (Oryza Sativa Starch). Phenylene Bis-diphenyltriazine. Water (Aqua). Glycerin. Bis-ethylhexyloxyphenol Methoxyphenyl Triazine. Potassium Cetyl Phosphate. Glyceryl Stearate. Stearyl Alcohol. Tapioca Starch. Vp/eicosene Copolymer. Benzoic Acid. Caprylic/capric Triglyceride. Caprylyl Glycol. Fragrance (Parfum). Glyceryl Behenate. Glyceryl Dibehenate. Ppg-1-peg-9 Lauryl Glycol Ether. Red 33 (Ci 17200). Tocopheryl Glucoside. Tribehenin. Xanthan Gum", 
'["dehydrated","aging"]', "bestSeller", "../image/suncare/aveneSuncare.png"),

("avene06", "Eau Thermale Avène", "avene", "Hyaluron Activ B3 Concentrated Plumping Serum", "serum-treatment", 135.90, "Regenerates, tightens, anti-aging", 
"Everything accelerates with age. Aging cells spread and the skin functions at a slower pace. The Avène dermatological laboratories have created the Hyaluron Activ B3 serum, highly concentrated in pure hyaluronic acid (1.5%: high and low molecular weight) and niacinamide (6%) to act on the cause of aging and prolong the life of cells. After 4 hours, the skin is plumped, firmer and more elastic**: efficiency in its purest form. Tested on sensitive skin, this fragrance-free product is suitable for all areas of the face, even the eye area.",
"Avene Thermal Spring Water (Avene Aqua). Niacinamide. Glycerin. Pentylene Glycol. Sodium Hyaluronate. Adenosine. Citric Acid. Sodium Benzoate", 
'["aging","sensitive","dehydrated"]', NULL, "../image/serum&treatment/aveneB3serum.png"),

("avene07", "Eau Thermale Avène", "avene", "Cleanance Comedomed", "serum-treatment", 71.50, "Mattifies, Reduces imperfections, Soothes", 
"Cleanance Comedomed, an innovation from Laboratoires Eau Thermale Avène with proven effectiveness from seven days*, targets invisible & visible blemishes with a unique action, and limits their reappearance. Expert skincare for oily, blemish-prone skin, Cleanance Comedomed is formulated using Comedoclastin™, a plant extract from the seeds of milk thistle. This active ingredient with patented properties** directly targets blackheads, reduces existing blemishes and prevents new ones from appearing. Cleanance Comedomed, applied twice a day, reduces blemishes within seven days* and provides clinically proven*** anti-reappearance action. Can be used by adults and teenagers from the age of 12. Non-comedogenic, high-tolerance* for blemish-prone skin, its fast-absorbing, non-greasy texture leaves the skin mattified. Cleanance Comedomed can be used alone, alongside other products, or after acne medication (excluding oral isotretinoin).",
"Avene Thermal Spring Water (Avene Aqua). Isopropyl Alcohol. Peg-6. Glycerin. Silybum Marianum Fruit Extract. Silica. Polyacrylate-13. Polyisobutene. Polysorbate 20. Sorbitan Isostearate. Water (Aqua)", 
'["acne","uneven"]', NULL, "../image/serum&treatment/aveneComedomed.png"),
("avene08", "Eau Thermale Avène", "avene", "Hydrance Intense Rehydrating Serum", "serum-treatment", 85.50, "Strengthens skin barrier, Hydrates", 
"Formulated with Avène Thermal Spring Water, Hydrance INTENSE Rehydrating Serum offers intense, long-lasting hydration to dehydrated sensitive skin. This serum provides continuous hydration for up to 24 hours and deeply quenches dehydrated skin. Its fluid and light texture penetrates quickly into the skin and leaves it feeling fresh, soft and plump. Fine dehydration lines appear smoothed, and the skin regains comfort, softness and suppleness. Day after day, skin's complexion gets brighter.",
"Avene Thermal Spring Water (Avene Aqua). Niacinamide. Glycerin. Pentylene Glycol. Sodium Hyaluronate. Adenosine. Citric Acid. Sodium Benzoate", 
'["dehydrated","uneven"]', NULL, "../image/serum&treatment/aveneRehydratingSerum.png"),

("cetaphil01", "Cetaphil", "cetaphil", "Gentle Skin Cleanser", "cleanser", 68.90, "Dermatologically tested for healthy and beautiful skin.",
"This formula is clinically proven to provide continuous hydration to protect dryness, all while leaving the skin hydrated after cleansing. Formulated with Micellar Technology to gently yet effectively remove dirt, makeup and impurities, plus a dermatologist-backed blend of niacinamide (vitamin B3), panthenol (vitamin B5) and hydrating glycerin to reinforce the skin's natural moisture barrier. Defends against 5 signs of skin sensitivity including dryness, irritation, roughness, tightness and a weakened skin barrier.",
"Aqua, Glycerin, Cetearyl Alcohol, Panthenol, Niacinamide, Pantolactone, Xanthan Gum, Sodium Cocoyl Isethionate, Sodium Benzoate, Citric Acid",
'["sensitive","uneven"]', "bestSeller", "../image/cleanser/cetaphiilcleanser.png"),

("cetaphil02", "Cetaphil", "cetaphil", "Daily Facial Cleanser", "cleanser", 52.50, "Foaming Cleanser for combination to oily skin",
"This deep cleansing, gel formula with Hydrating Glycerin, Vitamin B3 & Pro-Vitamin B5 gently foams to cleanse while respecting the skin’s moisture barrier.",
"Aqua, Glycerin, Acrylates/C10-30 Alkyl Acrylate Crosspolymer, Sodium Benzoate, Disodium Laureth Sulfosuccinate, Cocamidopropyl Betaine, Sodium Chloride, Sodium Cocoamphoacetate, Panthenol, Pantolactone, Niacinamide, Citric Acid",
'["acne","uneven"]', NULL, "../image/cleanser/cetaphilFoamCleanser.png"),

("cetaphil03", "Cetaphil", "cetaphil", "Bright Healthy Radiance Brightness Refresh Toner", "toner", 55.50, "illuminates and hydrates skin for smoother skin.",
"Clinically proven to respect sensitive skin, the Bright Healthy Radiance Brightening Night Comfort Cream illuminates and hydrates skin for instantly brighter, softer and smoother skin. Defends against 5 signs of skin sensitivity including dryness, irritation, roughness, tightness and a weakened skin barrier.",
"Aqua, Butylene Glycol, Niacinamide, Glycerin, 1,2-hexanediol, Anhydroxylitol, Citric Acid, Ethylhexylglycerin, Hydrolyzed Cicer Seed Extract, Pancratium Maritimum Extract, Rhododendron Chrysanthum Leaf Extract, Sodium Citrate, Tocopherol, Tricholoma Matsutake Extract, Trisodium Ethylenediamine Disuccinate, Xylitol, Xylitylglucoside",
'["uneven","aging"]', NULL, "../image/toner/cetaphilBrighteningToner.png"),

("cetaphil04", "Cetaphil", "cetaphil", "Optimal Hydration 48 Hour Activation Serum", "serum-treatment", 76.00, "intensely replenishing skin's hydration",
"This creamy serum instantly absorbs to deliver deep 48 hour hydration. Featuring our exclusive HydroSensitiv™ Complex with soothing blue daisy to deepen dynamic hydration, while the formula soothes skin sensitivity and helps to improve the quality of sensitive skin. Plus hyaluronic acid, sunflower seed oil, pro-vitamin B5 and antioxidant rich vitamin E to rehydrate and restore skin's appearance. This lightweight serum instantly absorbs and can be used alone or with Optimal Hydration Healthy Glow Daily Cream for an extra boost to skin's hydration. Ideal for sensitive, dry or dehydrated skin. Defends against 5 signs of skin sensitivity including dryness, irritation, roughness, tightness and a weakened skin barrier.",
"Water, Glycerin, Sorbitol, Coco-Caprylate/​Caprate, Glyceryl Citrate/​Lactate/​Linoleate/​Oleate, Helianthus Annuus (Sunflower) Seed Oil, Octyldodecanol, Hexyldecanol, Hexyldecyl Laurate, Distarch Phosphate, Acrylates/​C10-30 Alkyl Acrylate Crosspolymer, Anhydroxylitol, Butyrospermum Parkii Oil, Citric Acid, Dicaprylyl Carbonate, Disodium Cocoyl Glutamate, Globularia Alypum Leaf Extract (Blue Daisy), Hydrolyzed Hyaluronic Acid, Panthenol (Vitamin B5), Pantolactone, Phenoxyethanol, Propylene Glycol, Sodium Benzoate, Sodium Hydroxide, Sodium Polyacrylate, Tocopherol (Vitamin E), Tocopheryl Acetate (Vitamin E Acetate), Xylitol, Xylitylglucoside",
'["dehydrated","aging"]', "bestSeller", "../image/serum&treatment/cetaphilHydratingSerum.png"),

("cetaphil05", "Cetaphil", "cetaphil", "Bright Healthy Radiance Perfecting Serum", "serum-treatment", 132.90, "brighter and healthier skin in 14 days",
"The Bright Healthy Radiance Perfecting Serum is clinically proven to reduce the appearance of dark spots in as fast as 14 days by delivering 7x Power. Formulated with GentleBright Technology™ and now with Advanced Peptide and Antioxidant C, it evens the skin tone without harming the skin barrier, making it the perfect brightening serum for those with sensitive skin. Plus, this serum goes a step further by protecting your skin from harsh external environments such as blue light, pollution and 5 signs of skin sensitivity including dryness, irritation, roughness, tightness and a weakened skin barrier. Use alongside the Cetaphil Bright Healthy Radiance range of products for the best results.",
"Aqua, Glycerin, Niacinamide, Dimethicone, Acetyl Glycyl Beta-Alanine, 3-O-Ethyl Ascorbic Acid, Pancratium Maritimum Extract, Hydrolyzed Hyaluronic Acid, Tocopherol, Xylitylglucoside, Anhydroxylitol, Xylitol, Sodium Polyacryloyldimethyl Taurate, Phenoxyethanol, Undecane, Xanthan Gum, Tridecane, Calcium Aluminum Borosilicate, Sodium Hydroxide, Tin Oxide, CI 77891, Helianthus Annuus Seed Oil",
'["uneven","aging"]', NULL, "../image/serum&treatment/cetaphilRadianceSerum.png"),

("cetaphil06", "Cetaphil", "cetaphil", "Sun SPF 50+ Light Gel", "suncare", 85.50, "highly water resistant and suitable for sensitive skin",
"Helps prevent skin pigmentation and premature skin aging. Cetaphil Sun SPF50+ Light Gel offers high broad spectrum sun protection against UVA/UVB rays for both face and body. A lightweight sunscreen that is highly water resistant and suitable for sensitive skin, making it ideal for everyday protection.",
"Aqua, Ethylhexyl Methoxycinnamate, Alcohol, C12-15 Alkyl Benzoate, Diethylamino Hydroxybenzoyl Hexyl Benzoate, Bis-ethylhexyloxyphenol Methoxyphenyl Triazine, Dibutyl Adipate, Titanium Dioxide [nano], Dimethicone, Vp/eicosene Copolymer, Cyclodextrin, Ethylhexyl Triazone, Methylene Bis-benzotriazolyl Tetramethylbutylphenol [nano], Tocopherol, Polyglyceryl-2 Dipolyhydroxystearate, Silica, Decyl Glucoside, Triethanolamine, Xanthan Gum, Acrylates/c10-30 Alkyl Acrylate Crosspolymer, Trisodium Ethylenediamine Disuccinate, Lauryl Glucoside, Bht, Propylene Glycol.",
'["sensitive","uneven"]', NULL, "../image/suncare/cetaphilSunscreen.png"),

("cetaphil07", "Cetaphil", "cetaphil", "Intensive Moisturising Cream", "moisturizer", 65.00, "provide intense and lasting hydration",
"An intensely hydrating experience. This rich, hydrating cream is ideal for very dry and cracked skin on hands. Fast-absorbing and non-irritating, the Cetaphil Intensive Moisturising Cream will quickly soothe and restore the natural protective barrier of your skin.",
"Aqua, Behenyl Alcohol, Limnanthes Alba (meadowfoam) Seed Oil, Paraffinum Liquidum, Glycerin, Ethylhexyl Palmitate, Cetearyl Alcohol, Niacinamide (vitamin B3), Panthenol, Squalane, Ceteth-10, Steareth-20, Dimethicone, Tocopherol (vitamin E), Disodium EDTA, Polyaminopropyl Biguanide, Sodium Hydroxide.",
'["sensitive","dehydrated"]', NULL, "../image/moisturizer/cetaphilMoisturizer.png"),

("cetaphil08", "Cetaphil", "cetaphil", "Bright Healthy Radiance Brightening Night Comfort Cream", "moisturizer", 94.50, "brighten and even skin tone",
"Every night, Bright Healthy Radiance Brightening Night Comfort Cream works to correct dark spots, revive complexion clarity and replenish skin's moisture, so that you wake up with visibly luminous, radiant skin every morning. Defends against 5 signs of skin sensitivity including dryness, irritation, roughness, tightness and a weakened skin barrier.",
"Aqua, Glycerin, Niacinamide, Butylene Glycol, Hydrogenated Polydecene, 1,2-hexanediol, Cetearyl Alcohol, Cetearyl Olivate, Cetyl Ethylhexanoate, Sorbitan Olivate, Beeswax, Vinyl Dimethicone, Anhydroxylitol, Citric Acid, Ethylhexylglycerin, Glyceryl Stearate, Hyaluronic Acid, Hydrolyzed Cicer Seed Extract, Hydrolyzed Hyaluronic Acid, Pancratium Maritimum Extract, Pentasodium Pentetate, Propanediol, Rhododendron Chrysanthum Leaf Extract, Sodium Hyaluronate, Sodium Polyacryloyldimethyl Taurate, Tocopherol, Tricholoma Matsutake Extract, Trideceth-10, Xylitol, Xylitylglucoside",
'["uneven","aging"]', "bestSeller", "../image/moisturizer/cetaphilRadianceNightCream.png"),
("eucerin01", "Eucerin", "eucerin", "ProACNE Solution Toner", "toner", 66.90, "cleans and clears the acne",
"An acne treatment product that clears the skin and provides intensive cleansing for the T-Zone and other problem areas. The formula with Lactic Acid gently clears pores, moisturises skin and prepares it so it can absorb the full benefits of your care product.",
"Aqua, Alcohol Denat., Butylene Glycol, Poloxamer 124, Lactic Acid, PEG-40 Hydrogenated Castor Oil, Sodium Hydroxide, Glyceryl Caprylate, Phenoxyethanol, Parfum",
'["acne","sensitive"]', NULL, "../image/toner/eucerinAcneToner.png"),

("eucerin02", "Eucerin", "eucerin", "ProACNE Solution Cleansing Gel", "cleanser", 34.00, "Removes excess sebum",
"A non-comedogenic face wash with 6% Ampho-Tensides. This acne cleanser gently but effectively removes excess sebum while removing dirt and make-up. Leaves skin feeling clean, fresh and supple.",
"Aqua, Sodium Cocoamphoacetate, Propylene Glycol, Sodium Laureth Sulfate, Citric Acid, Sodium Benzoate, Salicylic Acid, Sodium Chloride",
'["acne","sensitive"]', NULL, "../image/cleanser/eucerineCleansingGel.png"),

("eucerin03", "Eucerin", "eucerin", "ProACNE Solution Triple Effect Serum", "serum-treatment", 109.90, "reduces acne and prevents new ones",
"A clinically tested Triple Effect Serum with patented Thiamidol formulated to reduce post-acne marks, reduce blemishes, and control shine. First visible results in 2 weeks and continuous improvement over time. *Clinical study, 40 females & males with persistent acne marks, 12 weeks of regular usage twice daily. Individual results may vary ^PiU study (n=100), 2 weeks of regular usage twice daily",
"Aqua, Alcohol Denat., Glycerin, Tapioca Starch, Carbomer, Salicylic Acid, Isobutylamido Thiazolyl Resorcinol, Decylene Glycol, Glycyrrhiza Inflata Root Extract, Panthenol or Dexpanthenol, Glucosylrutin, Isoquercitrin, Ammonium Acryloyldimethyltaurate/VP Copolymer, Pantolactone, Sodium Hydroxide, Trisodium EDTA, Citric Acid, Parfum",
'["acne","aging"]', NULL, "../image/serum&treatment/eucerineAcneSerum.png"),

("eucerin04", "Eucerin", "eucerin", "Spotless Brightening Booster Serum", "serum-treatment", 156.00, "reduces pigment spots and prevents their re-appearance",
"A Booster Serum with Thiamidol and concentrated Hyaluronic Acid for even and radiant skin. Now in new mono-chamber packaging, with same proven efficacy.",
"Aqua, Alcohol Denat., Butylene Glycol, Glycerin, Isopropyl Palmitate, Cetearyl Isononanoate, Diisopropyl Adipate, Propylheptyl Caprylate, Cetearyl Alcohol, Distarch Phosphate, Isobutylamido Thiazolyl Resorcinol, Sodium Ascorbyl Phosphate, Sodium Hyaluronate, Glycyrrhiza Inflata Root Extract, Tocopherol, Glucosylrutin, Sodium Stearoyl Glutamate, Glyceryl Stearate, Hydroxypropyl Starch Phosphate, Dehydroxanthan Gum, Xanthan Gum, Gellan Gum, Dimethicone, Isoquercitrin, Citric Acid, Sodium Chloride, Ethylhexylglycerin, Trisodium EDTA, Phenoxyethanol, Parfum",
'["uneven","aging"]', NULL, "../image/serum&treatment/eucerineBrighteningSerum.png"),

("eucerin05", "Eucerin", "eucerin", "DermatoCLEAN Balancing Facial Toner", "toner", 52.50, "Supports skin hydration: non-drying",
"A mild but effective hydrating face toner that prepares skin to absorb the active ingredients in care products without drying it out. Suitable for daily use and for sensitive skin.",
"Hyaluronic Acid, Glyco-Glycerol, Glyceryl Glucoside, Glycerin, Sodium Hyaluronate, Decyl Glucoside, Sodium Citrate, Citric Acid, Cocamidopropyl Betaine, Trisodium EDTA, Sodium Chloride, 1,2-Hexanediol, Phenoxyethanol",
'["dehydrated","acne"]', NULL, "../image/toner/eucerinHydrationToner.png"),

("eucerin06", "Eucerin", "eucerin", "Hyaluron-Filler + Elasticity Night", "moisturizer", 210.00, "Anti-aging night cream for mature skin",
"Plumps up deep wrinkles and improves elasticity. Skin feels firm and looks fresh and radiant.",
"Aqua, Glycerin, Cetearyl Alcohol, Butylene Glycol, Caprylic/Capric Triglyceride, Panthenol or Dexpanthenol, Glyceryl Stearate Citrate, Hydroxypropyl Starch Phosphate, Argania Spinosa Kernel Oil, Hydrogenated Coco-Glycerides, Butyrospermum Parkii Butter, Sodium Hyaluronate, Arctium Lappa Fruit Extract, Creatine, 1-Methylhydantoin-2-Imide, Isobutylamido Thiazolyl Resorcinol, Pantolactone, Tocopherol, Tapioca Starch, Xanthan Gum, Sodium Hydroxide, Citric Acid, Dimethicone, Trisodium EDTA, Caprylyl Glycol, 1,2-Hexanediol, Phenoxyethanol, Pentaerythrityl Tetra-di-t-butyl Hydroxyhydrocinnamate, Parfum",
'["aging","uneven"]', NULL, "../image/moisturizer/eucerinNightCream.png"),
("eucerin07", "Eucerin", "eucerin", "Sun Dry Touch Oil Control", "suncare", 100.90, "high sun protection for the face",
"Eucerin’s Advanced Spectral Technology offers very high factor UVA/UVB protection and HEVIS light defense. The sunscreen also supports skin’s own DNA repair mechanism and includes sebum-regulating Oil Control technology.",
"Aqua, C12-15 Alkyl Benzoate, Alcohol Denat., Butylene Glycol Dicaprylate/Dicaprate, Ethylhexyl Triazone, Bis-Ethylhexyloxyphenol Methoxyphenyl Triazine, Dibutyl Adipate, Diethylamino Hydroxybenzoyl Hexyl Benzoate, Glyceryl Stearate Citrate, Phenylbenzimidazole Sulfonic Acid, Silica, Tapioca Starch, Behenyl Alcohol, Cetearyl Alcohol, Silica Dimethyl Silylate, Carnitine, Glycyrrhetinic Acid, Glycyrrhiza Inflata Root Extract, Glycerin, Dimethicone, Hydroxypropyl Methylcellulose, Carrageenan, Xanthan Gum, Sodium Hydroxide, Trisodium EDTA, Hydroxyacetophenone, Ethylhexylglycerin, Phenoxyethanol",
'["acne","uneven"]', NULL, "../image/suncare/eucerineSuncare.png"),

("eucerin08", "Eucerin", "eucerin", "Aquaphor SOS Lip Repair", "lip-eyeCare", 21.60, "Soothes & Moisturize Cracked Lips",
"Most people suffer from dry and cracked lips at some point. They’re uncomfortable, sometimes painful, and can make us feel self-conscious too. They need SOS care, and Eucerin Aquaphor SOS Lip Repair delivers immediate care and relief within 60 seconds. The skin on our lips is thin and doesn’t have any sebaceous glands, so it’s prone to drying out. Cold winds and the sun dry our lips out further making matters worse. Eucerin Aquaphor SOS Lip Repair is clinically and dermatologically proven to soothe and repair dry, cracked lips. The formula, enriched with Glycerin, Dexpanthenol, Bisabolol and Vitamins C and E, creates the ideal protective barrier for lip skin regeneration and makes lips soft and supple again.",
"Aqua (Water), Cera Alba (Beeswax), Petrolatum, Butyrospermum Parkii (Shea) Butter, Glyceryl Stearate, Cetearyl Alcohol, Panthenol (Vitamin B5), Steareth-20, Sodium Chloride, Lanolin Alcohol, Bisabolol, Tocopherol (Vitamin E), Sodium Lactate, Glycerin, Propylene Glycol, Citric Acid.",
'["dehydrated"]', NULL, "../image/lip&eyeCare/eucerinLip.png"),

("eucerin09", "Eucerin", "eucerin", "Hyaluron [3X] Filler Night", "moisturizer", 130.90, "supports the skin’s regeneration process overnight",
"Counteracts the aging process. For visibly smoother, radiant, and younger looking skin.",
"Aqua, Glycerin, Butyrospermum Parkii Butter, Isopropyl Palmitate, Panthenol or Dexpanthenol, Caprylic/Capric Triglyceride, Cetyl Alcohol, Glyceryl Stearate Citrate, Hydrogenated Coco-Glycerides, Octyldodecanol, Stearyl Alcohol, Butylene Glycol, Hydroxypropyl Starch Phosphate, Behenyl Alcohol, Sodium Hyaluronate, Glycine Soja Germ Extract, Glycyrrhetinic Acid, Tocopherol, Pantolactone, Distarch Phosphate, Xanthan Gum, Citric Acid, Dimethicone, Trisodium EDTA, Caprylyl Glycol, 1,2-Hexanediol, Phenoxyethanol, Parfum",
'["aging","uneven"]', NULL, "../image/moisturizer/eurineHyaluron-fillerCream.png"),

("laRochePosay01", "La Roche-Posay", "laRochePosay", "Hyalu B5 Serum", "serum-treatment", 167.90, "Anti-wrinkle Concentrate Solution Repairing And Replumping",
"This ultra hydrating hyaluronic acid serum leaves skin feeling plump to the touch and repairs by replenishing skin’s natural moisture barrier. Formulated with pure hyaluronic acid and vitamin B5, this serum targets fine lines and dehydrated skin. Allergy tested formula with fragrance. Tested on sensitive skin.",
"Aqua / Water, Glycerin, Alcohol Denat, Propylene Glycol, Panthenol, Pentylene Glycol, Dimethicone, Peg-6 Caprylic/capric Glycerides, Ppg-6-decyltetradeceth-30, Glyceryl Isostearate, Madecassoside, Sodium Hyaluronate, Ammonium Polyacryloyldimethyl Taurate, Disodium Edta, Hydrolyzed Hyaluronic Acid, Caprylyl Glycol, Citric Acid, Xanthan Gum, Butylene Glycol, Tocopherol, Phenoxyethanol, Parfum /fragrance",
'["aging","dehydrated"]', "bestSeller", "../image/serum&treatment/lrpSerum.png"),

("laRochePosay02", "La Roche-Posay", "laRochePosay", "Cicaplast Baume B5+ Soothing Multi-Purpose Balm", "moisturizer", 139.90, "Helps To Nourish And Soothe Dry Skin",
"La Roche-Posay Cicaplast Baume B5 is a multi-purpose soothing balm designed to accelerate skin recovery and provide intense hydration. Formulated with a blend of madecassoside, panthenol (vitamin B5), and shea butter, it helps to repair and calm irritated, sensitive, or damaged skin. Whether it's due to dryness, redness, or after cosmetic procedures, this cream creates a protective barrier that soothes discomfort and promotes healing. Its rich, non-greasy texture absorbs easily, making it ideal for both face and body, including on sensitive areas like the lips, hands, and elbows. Suitable for all skin types, including those prone to acne or rosacea, La Roche-Posay Cicaplast Baume B5 is a trusted option for everyday skin care, providing immediate relief and long-term skin recovery.",
"Aqua, Hydrogenated Polyisobutene, Dimethicone, Glycerin, Butyrospermum Parkii Butter / Hea Butter, Panthenol, Propanediol, Butylene Glycol, Aluminum Starch Octenylsuccinate, Cetyl Peg/ppg-10/1 Dimethicone, Trihydroxystearin, Zinc Gluconate, Madecassoside, Tribioma, Manganese Gluconate, Silica, Aluminum Hydroxide, Magnesium Sulfate, Disodium Edta, Copper Gluconate, Capryloyl Glycine, Citric Acid, Acetylated Glycol Stearate, Polyglyceryl-4 Isostearate, Tocopherol, Pentaerythrityl Tetra-di-t-butyl Hydroxyhydrocinnamate, Ci 77891 / Titanium Dioxide",
'["acne","aging","dehydrated"]', NULL, "../image/moisturizer/lrpCream.png"),

("laRochePosay03", "La Roche-Posay", "laRochePosay", "Anthelios Invisible Fluid SPF50+ Non-Perfumed Sunscreen", "suncare", 101.90, "Daily invisible sunscreen with the best protection",
"La Roche-Posay Anthelios Invisible Fluid SPF50+ Non-Perfumed Sunscreen offers advanced broad-spectrum protection against harmful UVA and UVB rays, with a lightweight, invisible formula that provides long-lasting defense without leaving any residue. Ideal for sensitive skin, this non-perfumed sunscreen is enriched with La Roche-Posay's Thermal Spring Water to soothe and protect the skin. Its ultra-fluid texture absorbs quickly, ensuring a non-greasy finish and a matte look, making it perfect for daily use under makeup or for outdoor activities. With SPF 50+ and a high level of photostability, it helps prevent sunburn, premature aging, and skin damage caused by sun exposure, providing reliable protection for all skin types, including those prone to irritation or acne.",
"Aqua/water, Alcohol Denat., Diisopropyl Sebacate, Silica, Isopropyl Myristate, Ethylhexyl Salicylate, Ethylhexyltriazone, Bis-ethylhexyloxyphenolmethoxyphenyltriazine, Butylmethoxydibenzoylmethane, Glycerin, C12-22alkylacrylate/Hydroxyethylacrylate Copolymer, Propanediol, Drometrizole Trisiloxane, Perlite, Tocopherol, Caprylic/Capric Triglyceride, Acrylates/C10-30 Alkyl Acrylate Crosspolymer, Caprylyl Glycol, Hydroxyethylcellulose, Terephthalylidene Dicamphor Sulfonic Acid, Triethanolamine, Trisodium Ethylenediamine Disuccinate C227022/1.",
'["sensitve","uneven"]', NULL, "../image/suncare/lrpSunscreen.png"),

("laRochePosay04", "La Roche-Posay", "laRochePosay", "Cicaplast Lips", "lip-eyeCare", 33.90, "Soothes And Rebuilds Lips Skin Barrier",
"La Roche-Posay Cicaplast Lips is a soothing, reparative lip balm designed to provide intense hydration and protection for dry, chapped, or irritated lips. Enriched with a blend of nourishing ingredients like panthenol (vitamin B5) and shea butter, it helps to restore the skin's natural barrier, accelerate healing, and prevent further moisture loss. Its rich, non-greasy formula absorbs quickly, leaving the lips feeling soft, smooth, and comfortable without any sticky residue. Ideal for sensitive skin, La Roche-Posay Cicaplast Lips is perfect for daily use, offering long-lasting relief from dryness, cracking, and discomfort, making it a must-have for protecting your lips against harsh weather and environmental factors.",
"Aqua (Water), Dimethicone, Glycerin, Shea Butter (Butyrospermum Parkii Butter), Panthenol (Vitamin B5), Cera Alba (Beeswax), Caprylic/Capric Triglyceride, Hydrogenated Polyisobutene, Cetearyl Alcohol, Ceteareth-20, Sodium Chloride, Propylene Glycol, Tocopherol (Vitamin E), Butyrospermum Parkii (Shea) Butter Extract, Xanthan Gum, Citric Acid, Ethylhexylglycerin.",
'["dehydrated","aging"]', NULL, "../image/lip&eyeCare/lrpLip.png"),

("laRochePosay05", "La Roche-Posay", "laRochePosay", "Pigmentclar Eyes", "lip-eyeCare", 134.90, "Reduce Dark Brown Under-eye Circles",
"La Roche-Posay Pigmentclar Eyes is a targeted eye treatment designed to visibly reduce dark circles and brighten the delicate skin around the eyes. This lightweight, non-greasy formula is enriched with pharmaceutical-grade ingredients, including ferulic acid and phe-resorcinol, which work together to diminish the appearance of dark circles, puffiness, and fatigue signs. The product is specially formulated for sensitive skin and is clinically tested to ensure its safety and efficacy.",
"Aqua, Water, Glycerin, Butylene Glycol, Dimethicone, Niacinamide, Isopropyl Palmitate, Cetearyl Alcohol, Ammonium Polyacryldimethyltauramide, Ammonium Polyacryloyldimethyl Taurate, Butyrospermum Parkii Butter, Shea Butter, Peg-100 Stearate, Peg/ppg/polybutylene Glycol-8/5/3 Glycerin, Stearic Acid, Glyceryl Stearate, Dimethicone/vinyl Dimethicone Crosspolymer, Dimethiconol, Caffeine, Sodium Hydroxide, Silica, Ginkgo Biloba Extract, Ginkgo Biloba Leaf Extract, Palmitic Acid, Alumina, Phenylethyl Resorcinol, Ascorbyl Glucoside, Poloxamer 338, Disodium Edta, Isopropyl Titanium Triisostearate, Hydrolyzed Rice Protein, Caprylyl Glycol, Xanthan Gum, Ferulic Acid, Phenoxyethanol, Ci 77491, Ci 77492, Ci 77499, Iron Oxides, Ci 77891, Titanium Dioxide, Mica.",
'["uneven","aging"]', NULL, "../image/lip&eyeCare/lrpEye.png");
