<?php

class MerchantsTableSeeder extends Seeder {

	public function run()
	{
		$base_url = Config::get('env_vars.baseUrl');
		$merchants = array(
		 		array("name" => "AbeBooks",
		 					"slug" => "abebooks",
		 					"logo_url" => "$base_url/img/abebooks.gif",
		 					"description" => "AbeBooks is an online marketplace for books. Millions of books offered from thousands of booksellers around the world are for sale through the AbeBooks website.",
		 					'created_at' => date('Y-m-d H:i:s'),
            	'updated_at' => date('Y-m-d H:i:s')
            	),
		 		array("name" => "Amazon",
		 					"slug" => "amazon",
		 					"logo_url" => "$base_url/img/amazon.gif",
		 					"aff_code" => "recycleabook-20",
		 					"description" => "Rent textbooks and save up to 70% off new print. You can keep your textbooks for a semester, and when it comes time to send your books back, Amazon pays for return shipping."),
		 		array("name" => "Barnes & Noble",
		 					"slug" => "bn",
		 					"logo_url" => "$base_url/img/bn.gif",
		 					"description" => "Barnes and Nobles is known for the excellence in customer service, and huge inventory. The B&N marketplace offers millions of new and used textbooks from many trusted sellers, usually at discounted prices."),
		 		array("name" => "BetterWorldBooks.com",
		 					"slug" => "betterworldbooks",
		 					"logo_url" => "$base_url/img/bwbooks88x30.gif",
		 					"description" => "Better World Books not only sells books, they also donate books and fund literacy initiatives worldwide. With more than 8 million new and used titles in stock, they are a self-sustaining company that creates social, economic, and environmental value. Please refer to the seller\"s comments before ordering."
		 					),
		 		array("name" => "BiggerBooks.com",
		 					"slug" => "biggerbooks",
		 					"logo_url" => "$base_url/img/biggerbooks.gif",
		 					"description" => "BiggerBooks offers a wide selection of new and used books and partners with the largest publishers and distribution centers to offer cheap prices."),
		 		array("name" => "BookByte.com",
		 					"slug" => "bookbyte",
		 					"logo_url" => "$base_url/img/bookbyte.jpg",
		 					"description" => "Bookbyte has been providing cheap textbooks to college students for more than a decade. Their inventory includes all subjects and used, new, and rental offerings. Free shipping on most non-marketplace orders over $49. "),
		 		array("name" => "BookRenter.com",
		 					"slug" => "bookrenter",
		 					"logo_url" => "$base_url/img/bookrenter.gif",
		 					"description" => "BookRenter delivers free standard shipping both ways, a 21-day no-questions-asked rental-return policy, low prices on over 5 million textbooks, and five flexible rental periods. Write or highlight in your rentals."),
		 		array("name" => "Bookstores.com",
		 					"slug" => "bookstores",
		 					"logo_url" => "$base_url/img/bookstorescom.gif",
		 					"description" => "Bookstores.com is an marketplace online where book buyers and sellers can connect safely and securely. Bookstores.com is dedicated to creating a safe and reputable venue for customers to buy and sell books. They back this buy having a 14 day guarantee on the condition of every item described in their marketplace."),
		 		array("name" => "BuyBack101.com",
		 					"slug" => "buyback101",
		 					"logo_url" => "$base_url/img/buyback101.png",
		 					"description" => "Selling your textbooks to Buyback101.com is a great way to earn extra money."),
		 		array("name" => "CampusBookRentals.com",
		 					"slug" => "campusbookrentals",
		 					"logo_url" => "$base_url/img/campusbookrentals.jpg",
		 					"description" => "CampusBookRentals.com began renting textbooks in 2007. Since then, they\"ve served thousands of students on more than 5,000 different college campuses. Every rental comes with a worry-free guarantee that allows you to return your book within the first 30 days of your order. Free shipping both ways. "),
		 		array("name" => "Chegg",
		 					"slug" => "chegg",
		 					"logo_url" => "$base_url/img/chegg120x30.png",
		 					"description" => "Chegg is the number-one provider of textbook rentals. The company has been helping college students get cheap textbooks for years. All rentals come with a 21-day Satisfaction Guarantee, 14 days for eTextbooks."),
		 		array("name" => "CourseSmart",
		 					"slug" => "coursesmart",
		 					"logo_url" => "$base_url/img/coursesmart.gif",
		 					"description" => "Study smarter with eTextbooks and eResources from CourseSmart, and save up to 60% off the price of print textbooks."),
		 		array("name" => "Ebay",
		 					"slug" => "ebay",
		 					"logo_url" => "$base_url/img/ebay.jpg",
		 					"description" => "With more than 100 million active users globally, eBay is the world\"s largest online marketplace, where practically anyone can buy and sell practically anything. With auctions, you set your price and you can save a bundle."),
		 		array("name" => "eCampus",
		 					"slug" => "ecampus",
		 					"logo_url" => "$base_url/img/ecampus.gif",
		 					"description" => " The Rent and Return Program by eCampus.com is a low-cost alternative to purchasing textbooks. You don\"t own the book, you are simply borrowing it from eCampus.com for a fee and returning it at the end of the rental term you selected."),
				array("name" => "Half.com",
							"slug" => "half",
							"logo_url" => "$base_url/img/half_logo.jpg",
							"description" => "Buying textbooks on Half.com can offer great savings. Often Half.com offers older editions of textbooks at a substantial discount. When you find the textbook you\"re looking for, click \"See Other Editions\" to see if there are older versions offered at better prices. Before you buy, you might want to confirm with your instructor to make sure an older edition is acceptable for the course. Sometimes older editions will have different exercises or may be missing chapters. If you\"re in doubt, purchase the correct edition and you\"ll still save a lot of money. If you need your book in a hurry, be sure to choose Expedited Mail as the method of shipment. The default method, Media Mail, can take as many as 14 days for delivery. "),
				array("name" => "KnetBooks",
							"slug" => "knetbooks",
							"logo_url" => "$base_url/img/knetbooks.gif",
							"description" => "KnetBooks offers free shipping both ways as well as the option to rent your textbooks for different periods of time in order to better accommodate your needs. If you decide that you need to keep your book rental for a longer period, you can add 15 or 30 days for a small fee. Most rentals ship within 48 hours. Once you receive the rented textbook, keep the box so you can reuse it when you ship your textbook back for free. "),
				array("name" => "Powells.com",
							"slug" => "powells",
							"logo_url" => "$base_url/img/powells.png",
							"description" => "Powell's Books is the largest independent used and new bookstore in the world. We carry an extensive collection of out of print rare, and technical titles as well as many other new and used books in every field."),
				array("name" => "RecycleABook.com",
							"slug" => "recycleabook",
							"logo_url" => "$base_url/img/recycleabook.png",
							"description" => "RecycleABook is a top-rated buyer and offers some of the best rates in the textbook buy-back industry."),
				array("name" => "SellBackBooks.com",
							"slug" => "sellbackbooks",
							"logo_url" => "$base_url/img/sellbackbooks.gif",
							"description" => "Sell used books and textbooks to SellBackBooks.com! We make it simple, fast and profitable for you to sell books. You don't want to be stuck with old textbooks on your shelf that you are never going to open again, so get rid of them! Sell textbooks back to us, and get extra cash in your pockets! SellBackBooks.com makes it easy to sell textbooks online for more money than your campus bookstore will pay!"),
				array("name" => "TextBooksRUs.com",
							"slug" => "textbooksrus",
							"logo_url" => "$base_url/img/textbooksrus.gif",
							"description" => "TextbooksRus.com has been in operation since 2002 but has been in the book business for over 15 years. They offer a massive inventory of domestic and international editions and multiple shipping options. Free shipping on most non-marketplace orders over $49."),
				array("name" => "TextBookX.com",
							"slug" => "textbookx",
							"logo_url" => "$base_url/img/TextBookXlogo.gif",
							"description" => "TextbookX.com offers new, used, and digital textbooks as well as rentals. Free shipping on most non-marketplace orders over $49."),
				array("name" => "ValoreBooks",
							"slug" => "valore",
							"logo_url" => "$base_url/img/valoremarketplace.gif",
							"description" => "Valore rental books are an affordable and eco-friendly option. Valore offers expedited shipping to you when you need books ASAP and they pay for the return shipping when you are done with the books. ")
		);

		DB::table('merchants')->delete();

		foreach($merchants as $merchant){
			DB::table('merchants')->insert($merchant);
		}


	}

}
